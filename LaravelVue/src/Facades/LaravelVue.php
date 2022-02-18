<?php

namespace Phonglg\LaravelVue\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelVue extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelvue';
    }
}
