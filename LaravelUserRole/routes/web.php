<?php
use Illuminate\Support\Facades\Route;   
 

Route::group(['middleware' => ['web','auth']], function () {  
    Route::prefix('admin')->group(__DIR__ . '/roleRoutes.php');
    Route::prefix('admin')->group(__DIR__ . '/userRoutes.php');
    Route::prefix('admin')->group(__DIR__ . '/customerRoutes.php');
});
