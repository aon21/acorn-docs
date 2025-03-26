<?php

namespace Aon\AcornDocs;

use Illuminate\Filesystem\Filesystem;
use Aon\AcornDocs\Interfaces\BlockParserInterface;
use Aon\AcornDocs\Interfaces\DocRendererInterface;
use Aon\AcornDocs\Resources\BlockResource;
use Aon\AcornDocs\DTO\BlockDTO;

class AcornDocs
{
    public function __construct(
        protected Filesystem $files,
        protected BlockParserInterface $parser,
        protected DocRendererInterface $renderer,
    ) {}

    public function generate(array $config): void
    {
        foreach ($config['paths'] as $path) {
            $this->processDirectory(
                base_path($path['directory']),
                rtrim($path['namespace'], '\\') . '\\',
                $config['output_path']
            );
        }
    }

    protected function processDirectory(string $directory, string $namespace, string $outputPath): void
    {
        $files = glob($directory . '/*.php');

        foreach ($files as $file) {
            $this->processFile($file, $namespace, $outputPath);
        }
    }

    protected function processFile(string $file, string $namespace, string $outputPath): void
    {
        require_once $file;

        $class = $namespace . pathinfo($file, PATHINFO_FILENAME);

        if (!class_exists($class)) {
            return;
        }

        $dto = $this->parser->parse($class);

        if (!$dto instanceof BlockDTO) {
            return;
        }

        $this->writeDocumentation(new BlockResource($dto), $class, $outputPath);
    }

    protected function writeDocumentation(BlockResource $resource, string $class, string $outputPath): void
    {
        $markdown = $this->renderer->render($resource);
        $filename = strtolower(class_basename($class)) . '.md';

        $this->files->ensureDirectoryExists($outputPath);
        $this->files->put("{$outputPath}/{$filename}", $markdown);
    }
}
