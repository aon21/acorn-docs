<?php
namespace Aon\AcornDocs\Console;

use Illuminate\Console\Command;
use Aon\AcornDocs\AcornDocs;

class GenerateDocsCommand extends Command
{
    protected $signature = 'docs:generate';
    protected $description = 'Generate documentation for ACF blocks.';

    public function __construct(protected AcornDocs $generator)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->generator->generate(config('acorn-docs'));

        $this->info('✅ Block documentation generated successfully!');
    }
}
