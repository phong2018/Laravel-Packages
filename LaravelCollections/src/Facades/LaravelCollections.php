<?php

namespace Phonglg\LaravelCollections\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelCollections extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelcollections';
    }
}
