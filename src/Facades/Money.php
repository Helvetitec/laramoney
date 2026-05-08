<?php

namespace LaraMoney\Facades;

use Illuminate\Support\Facades\Facade;

class Money extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laramoney';
    }
}