<?php

namespace Phonglg\LaravelTest\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelTest extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laraveltest';
    }
}
