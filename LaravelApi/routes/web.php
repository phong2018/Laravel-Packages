<?php
use Illuminate\Support\Facades\Route;    
use Phonglg\LaravelPusher\Events\MessageNotification;
 

// use for app cotuong
Route::get('/LaravelApi', function () {
    return "laravel LaravelApi";
});


Route::group(['middleware' => ['web']], function () {   
 
}); 

