<?php

namespace Phonglg\LaravelEventsListeners\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelEventsListeners extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laraveleventslisteners';
    }
}
