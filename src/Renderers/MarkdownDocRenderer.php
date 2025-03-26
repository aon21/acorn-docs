<?php

namespace Aon\AcornDocs\Renderers;

use Aon\AcornDocs\Interfaces\DocRendererInterface;
use Aon\AcornDocs\Resources\BlockResource;

class MarkdownDocRenderer implements DocRendererInterface
{
    public function render(BlockResource $block): string
    {
        return view('acorn-docs::markdown', $block->viewData())->render();
    }
}
