<?php

namespace Phonglg\LaravelAuthGithub\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelAuthGithub extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelauthgithub';
    }
}
