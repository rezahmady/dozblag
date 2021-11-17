<?php

namespace App\Services\Widget\Facades;

use Illuminate\Support\Facades\Facade;

class Widget extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Widget';
    }

}
