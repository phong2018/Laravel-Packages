<?php

namespace Phonglg\LaravelUserRole\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelUserRole extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laraveluserrole';
    }
}
