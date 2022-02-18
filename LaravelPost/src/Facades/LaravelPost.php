<?php

namespace Phonglg\LaravelPost\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelPost extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelpost';
    }
}
