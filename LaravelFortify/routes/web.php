<?php
use Illuminate\Support\Facades\Route;    
 

// use for app cotuong
Route::get('/laravelfortify', function () {
    return "laravel laravelfortify";
});

//---------
Route::group(['middleware' => ['web','auth','verified']], function () {  
    Route::view('/profile/edit','laravelfortify::profile.edit')->name('profile.edit');
    Route::view('/profile/password','laravelfortify::profile.password')->name('profile.password');
});
 