<?php
use Illuminate\Support\Facades\Route;     
  



Route::group(['middleware' => ['web']], function () {   

    Route::get('/rateLimiting', function () {
        return "laravel rateLimiting";
    })->middleware(['throttle:only_five_visits']);     
      
}); 

