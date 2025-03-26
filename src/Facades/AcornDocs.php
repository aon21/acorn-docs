<?php

namespace Aon\AcornDocs\Facades;

use Illuminate\Support\Facades\Facade;

class AcornDocs extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Aon\AcornDocs\AcornDocs::class;
    }
}
