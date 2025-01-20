<?php

namespace Akika\LaravelNCBA\Facades;

use Illuminate\Support\Facades\Facade;

class Ncba extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ncba';
    }
}
