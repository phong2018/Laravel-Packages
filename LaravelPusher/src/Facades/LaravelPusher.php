<?php

namespace Phonglg\LaravelPusher\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelPusher extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelpusher';
    }
}
