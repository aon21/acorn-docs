<?php

namespace Aon\AcornDocs\Parsers;

use phpDocumentor\Reflection\DocBlockFactoryInterface;
use ReflectionClass;
use phpDocumentor\Reflection\DocBlockFactory;
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
            annotations: $this->getBlockAnnotations($refClass)
        );
    }

    protected function getBlockAnnotations(\ReflectionClass $class): array
    {
        $results = [];
        $docComment = $class->getDocComment();

        if (! $docComment) {
            return $results;
        }

        $docBlock = $this->docFactory->create($docComment);
        $requestedTags = config('acorn-docs.annotations', []);

        foreach ($requestedTags as $tagName) {
            $tags = $docBlock->getTagsByName($tagName);

            if (empty($tags)) {
                continue;
            }

            $tag = $tags[0];

            if (!method_exists($tag, 'getDescription')) {
                continue;
            }

            $description = $tag->getDescription();

            if (!method_exists($description, 'render')) {
                continue;
            }

            $results[$tagName] = $description->render();
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
