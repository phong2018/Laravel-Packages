<?php

namespace Phonglg\LaravelAuth\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelAuth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelauth';
    }
}
