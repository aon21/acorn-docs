<?php

namespace Aon\AcornDocs\Parsers;

use phpDocumentor\Reflection\DocBlockFactoryInterface;
use phpDocumentor\Reflection\DocBlockFactory;
use ReflectionClass;
use ReflectionMethod;
use Aon\AcornDocs\Interfaces\BlockParserInterface;
use Aon\AcornDocs\DTO\BlockDTO;

class BlockParser implements BlockParserInterface
{
    protected DocBlockFactoryInterface $docFactory;

    public function __construct()
    {
        $this->docFactory = DocBlockFactory::createInstance();
    }

    public function parse(string $class): ?BlockDTO
    {
        if (!class_exists($class)) {
            return null;
        }

        $refClass = new ReflectionClass($class);

        return new BlockDTO(
            properties: $this->getBlockProperties($refClass),
            classAnnotations: $this->getClassAnnotations($refClass),
            classMethodAnnotations: $this->getClassMethodAnnotations($refClass),
        );
    }

    protected function getClassAnnotations(ReflectionClass $class): array
    {
        return $this->extractAnnotationsFromDocComment($class->getDocComment());
    }

    protected function getClassMethodAnnotations(ReflectionClass $class): array
    {
        $results = [];
        $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);

        foreach ($methods as $method) {
            $annotations = $this->extractAnnotationsFromDocComment($method->getDocComment());

            if (!empty($annotations)) {
                $results[$method->getName()] = $annotations;
            }
        }

        return $results;
    }

    private function extractAnnotationsFromDocComment(?string $docComment): array
    {
        if (!$docComment) {
            return [];
        }

        $docBlock = $this->docFactory->create($docComment);
        $requestedTags = config('acorn-docs.annotations', []);
        $results = [];

        foreach ($requestedTags as $tagName) {
            $tag = $docBlock->getTagsByName($tagName)[0] ?? null;

            if (
                $tag &&
                method_exists($tag, 'getDescription') &&
                method_exists($tag->getDescription(), 'render')
            ) {
                $results[$tagName] = $tag->getDescription()->render();
            }
        }

        return $results;
    }

    protected function getBlockProperties(ReflectionClass $class): array
    {
        $results = [];
        $requested = config('acorn-docs.properties', []);
        $defaults = $class->getDefaultProperties();

        foreach ($requested as $key) {
            $results[$key] = $defaults[$key] ?? null;
        }

        return $results;
    }
}
