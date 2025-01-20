<?php

namespace Akika\LaravelNcba\Facades;

use Illuminate\Support\Facades\Facade;

class Ncba extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ncba';
    }
}
