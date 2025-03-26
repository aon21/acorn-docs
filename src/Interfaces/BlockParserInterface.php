<?php

namespace Aon\AcornDocs\Interfaces;

use Aon\AcornDocs\DTO\BlockDTO;

interface BlockParserInterface
{
    public function parse(string $class): ?BlockDTO;
}

