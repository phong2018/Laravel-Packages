<?php

namespace Phonglg\LaravelFortify\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelFortify extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelfortify';
    }
}
