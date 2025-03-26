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
        $props = $refClass->getDefaultProperties();

        return new BlockDTO(
            name: $props['name'] ?? $refClass->getShortName(),
            description: $props['description'] ?? '',
            category: $props['category'] ?? '',
            icon: $props['icon'] ?? '',
            supports: $props['supports'] ?? [],
        );
    }
}
