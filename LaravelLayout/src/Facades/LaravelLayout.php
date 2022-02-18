<?php

namespace Phonglg\LaravelLayout\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelLayout extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravellayout';
    }
}
