<?php
use Illuminate\Support\Facades\Route;   

Route::group(['middleware' => ['web']], function () { 
    Route::prefix('')->group(__DIR__ . '/authRoutes.php');  
});
Route::group(['middleware' => ['web','auth']], function () {   
    Route::prefix('')->group(__DIR__ . '/accountRoutes.php');
});
