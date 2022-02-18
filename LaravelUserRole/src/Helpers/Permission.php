<?php

namespace Phonglg\LaravelUserRole\Helpers;

use Illuminate\Support\Facades\File;

class Permission
{
    public static function getModels()
    {
        $models = config('laraveluserrole.models');

        return $models;
    }
    
    public static function getPermissions($model)
    {
        $permissions = config('laraveluserrole.permissionsForRole.'.$model.'.permissions');

        return $permissions;
    }  
}