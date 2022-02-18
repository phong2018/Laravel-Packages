<?php
use Illuminate\Support\Facades\Route;
use Phonglg\LaravelZaloPay\Controllers\ZaloController;

// use for app cotuong
Route::get('/laravelZaloPay', function () {
    return "laravel laravelZaloPay";
});


Route::group(['middleware' => ['web']], function () {   
    Route::get('/zalopay', [ZaloController::class, 'index'])->name('zalo.index'); 
});
