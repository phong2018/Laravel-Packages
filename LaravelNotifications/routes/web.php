<?php

use Phonglg\LaravelNotifications\Controllers\CallNoitification;
use Illuminate\Support\Facades\Route; 

// use for app cotuong
Route::get('/LaravelNotifications', function () {
    return "laravel LaravelNotifications";
});


Route::group(['middleware' => ['web']], function () {   
 
    Route::get('/SendNotificationsViaEmail',[CallNoitification::class,'SendNotificationsViaEmail']);

    Route::get('/SendNotificationsViaDatabase',[CallNoitification::class,'SendNotificationsViaDatabase']);

    Route::get('/getNotificationsFromDatabase',[CallNoitification::class,'getNotificationsFromDatabase']);    
}); 

