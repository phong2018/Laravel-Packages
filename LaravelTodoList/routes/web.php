<?php
use Illuminate\Support\Facades\Route;    
use Phonglg\LaravelPusher\Events\MessageNotification;
 

// use for app cotuong
Route::get('/LaravelTodoList', function () {
    return "laravel LaravelTodoList";
});


Route::group(['middleware' => ['web']], function () {   
 
}); 

