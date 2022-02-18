<?php

namespace Phonglg\LaravelEcommerce\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelEcommerce extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelecommerce';
    }
}
