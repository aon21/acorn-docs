<?php

namespace Aon\AcornDocs\DTO;

class BlockDTO
{
    public function __construct(
        public string $name,
        public string $description,
        public string $category,
        public string $icon,
        public array  $supports,
    ) {}
}
