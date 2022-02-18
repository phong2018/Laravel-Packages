<?php

namespace Phonglg\LaravelTransaction\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelTransaction extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laraveltransaction';
    }
}
