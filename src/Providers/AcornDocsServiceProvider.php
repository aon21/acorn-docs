<?php

namespace Aon\AcornDocs\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Aon\AcornDocs\AcornDocs;
use Aon\AcornDocs\Console\GenerateDocsCommand;
use Aon\AcornDocs\Interfaces\BlockParserInterface;
use Aon\AcornDocs\Interfaces\DocRendererInterface;
use Aon\AcornDocs\Parsers\BlockParser;
use Aon\AcornDocs\Renderers\MarkdownRenderer;

class AcornDocsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(BlockParserInterface::class, BlockParser::class);
        $this->app->singleton(DocRendererInterface::class, MarkdownRenderer::class);

        $this->app->singleton(AcornDocs::class, function ($app) {
            return new AcornDocs(
                $app->make(Filesystem::class),
                $app->make(BlockParserInterface::class),
                $app->make(DocRendererInterface::class),
            );
        });

        $this->mergeConfigFrom(__DIR__ . '/../../config/acorn-docs.php', 'acorn-docs');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'acorn-docs');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/acorn-docs'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../../config/acorn-docs.php' => $this->app->configPath('acorn-docs.php'),
        ], 'config');

        $this->commands([
            GenerateDocsCommand::class,
        ]);
    }

}
