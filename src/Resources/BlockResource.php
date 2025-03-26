<?php

namespace Aon\AcornDocs\Resources;

use Aon\AcornDocs\DTO\BlockDTO;

class BlockResource
{
    public function __construct(
        protected BlockDTO $block
    ) {}

    public function viewData(): array
    {
        return [
            'block' => $this->block,
        ];
    }
}
