<?php

namespace Phonglg\LaravelReact\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelReact extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravelreact';
    }
}
