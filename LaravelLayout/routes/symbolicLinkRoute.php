<?php

use Illuminate\Support\Facades\Artisan; 
use Illuminate\Support\Facades\Route;

Route::get('symbolicLink', function(){
    Artisan::call('storage:link', []);
    return 'success';
});

?>