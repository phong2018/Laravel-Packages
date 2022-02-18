<?php

namespace Phonglg\LaravelApi\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelApi extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelapi';
    }
}
