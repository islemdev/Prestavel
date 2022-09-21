<?php

namespace Islemdev\Prestavel\Facades;

use Illuminate\Support\Facades\Facade;

class PrestavelConnector extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'PrestavelConnector';
    }
}