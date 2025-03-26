<?php

namespace Aon\AcornDocs\Resources;

use Aon\AcornDocs\DTO\BlockDTO;

class BlockResource
{
    public function __construct(
        protected BlockDTO $block
    ) {}

    public function toArray(): array
    {
        return [
            'name'        => $this->block->name,
            'description' => $this->block->description,
            'category'    => $this->block->category,
            'icon'        => $this->block->icon,
            'supports'    => $this->block->supports,
        ];
    }

    public function viewData(): array
    {
        return [
            'block' => $this->toArray(),
        ];
    }
}
