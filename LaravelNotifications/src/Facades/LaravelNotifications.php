<?php

namespace Phonglg\LaravelNotifications\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelNotifications extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelnotifications';
    }
}
