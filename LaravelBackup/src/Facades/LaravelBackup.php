<?php

namespace Phonglg\LaravelBackup\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelBackup extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelbackup';
    }
}
