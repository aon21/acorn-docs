<?php

namespace Aon\AcornDocs\Interfaces;

use Aon\AcornDocs\Resources\BlockResource;

interface DocRendererInterface
{
    public function render(BlockResource $block): string;
}

