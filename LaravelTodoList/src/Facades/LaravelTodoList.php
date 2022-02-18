<?php

namespace Phonglg\LaravelTodoList\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelTodoList extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laraveltodolist';
    }
}
