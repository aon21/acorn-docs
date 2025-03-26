<?php
namespace Aon\AcornDocs\Console;

use Illuminate\Console\Command;
use Aon\AcornDocs\AcornDocs;

class GenerateDocsCommand extends Command
{
    protected $signature = 'docs:generate';
    protected $description = 'Generate documentation for ACF blocks.';

    protected AcornDocs $generator;

    public function __construct(AcornDocs $generator)
    {
        parent::__construct();
        $this->generator = $generator;
    }

    public function handle(): void
    {
        $blocksPath = get_theme_file_path('/app/Blocks');
        $outputPath = base_path('docs/blocks');

        $this->generator->generate($blocksPath, $outputPath);

        $this->info('✅ Block documentation generated successfully!');
    }
}
