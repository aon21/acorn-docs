<?php
namespace Aon\AcornDocs\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Aon\AcornDocs\AcornDocs;
use Aon\AcornDocs\Console\GenerateDocsCommand;

class AcornDocsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AcornDocs::class, function ($app) {
            return new AcornDocs($app->make(Filesystem::class));
        });

        $this->mergeConfigFrom(__DIR__.'/../../config/acorn-docs.php', 'acorn-docs');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/acorn-docs.php' => $this->app->configPath('acorn-docs.php'),
        ], 'config');

        $this->commands([
            GenerateDocsCommand::class,
        ]);
    }
}
