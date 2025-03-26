<?php

namespace Aon\AcornDocs;

use Illuminate\Filesystem\Filesystem;
use Aon\AcornDocs\Interfaces\BlockParserInterface;
use Aon\AcornDocs\Interfaces\DocRendererInterface;
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
            $namespace = rtrim($path['namespace'], '\\') . '\\';
            $dir = base_path($path['directory']);
            $files = glob($dir . '/*.php');

            foreach ($files as $file) {
                require_once $file;

                $class = $namespace . basename($file, '.php');
                $block = $this->parser->parse($class);

                if (!$block instanceof BlockDTO) {
                    continue;
                }

                $markdown = $this->renderer->render($block);
                $filename = strtolower(class_basename($class)) . '.md';

                $this->files->ensureDirectoryExists($config['output_path']);
                $this->files->put($config['output_path'] . '/' . $filename, $markdown);
            }
        }
    }
}
