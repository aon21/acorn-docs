<?php

namespace Aon\AcornDocs\DTO;

class BlockDTO
{
    public function __construct(
        public ?array $properties = [],
        public ?array $classAnnotations = [],
        public ?array $classMethodAnnotations = [],
    ) {}
}
