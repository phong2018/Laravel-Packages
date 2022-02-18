<?php

namespace Phonglg\LaravelSchedule\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelSchedule extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelschedule';
    }
}
