<?php
namespace Aon\AcornDocs;

use Illuminate\Filesystem\Filesystem;
use phpDocumentor\Reflection\DocBlockFactory;
use ReflectionClass;

class AcornDocs
{
    protected Filesystem $files;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    public function generate(string $blocksPath, string $outputPath): void
    {
        $docFactory = DocBlockFactory::createInstance();
        $namespace = 'App\\Blocks\\';

        $files = glob($blocksPath . '/*.php');

        foreach ($files as $file) {
            require_once $file;

            $className = $namespace . basename($file, '.php');
            if (!class_exists($className)) {
                continue;
            }

            $refClass = new ReflectionClass($className);
            $doc = $refClass->getDocComment();
            $blockDoc = $doc ? $docFactory->create($doc) : null;
            $props = $refClass->getDefaultProperties();

            $name = $props['name'] ?? $refClass->getShortName();
            $desc = $props['description'] ?? '';
            $category = $props['category'] ?? '';
            $icon = $props['icon'] ?? '';
            $supports = json_encode($props['supports'] ?? [], JSON_PRETTY_PRINT);

            $markdown = "# {$name} Block\n\n";
            $markdown .= "**Description:** {$desc}\n\n";
            $markdown .= "**Category:** {$category}\n\n";
            $markdown .= "**Icon:** {$icon}\n\n";
            $markdown .= "## Supports\n\n```json\n{$supports}\n```\n";

            $fileName = strtolower($refClass->getShortName()) . '.md';
            $this->files->ensureDirectoryExists($outputPath);
            $this->files->put($outputPath . '/' . $fileName, $markdown);
        }
    }
}

