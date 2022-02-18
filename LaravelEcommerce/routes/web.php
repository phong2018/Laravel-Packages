<?php
use Illuminate\Support\Facades\Route;  

Route::group(['middleware' => ['web']], function () {  
    Route::prefix('')->group(__DIR__ . '/shopRoutes.php');
    Route::prefix('')->group(__DIR__ . '/cartRoutes.php');
    Route::prefix('')->group(__DIR__ . '/orderRoutes.php');
});

Route::group(['middleware' => ['web','auth']], function () {  
    Route::prefix('admin')->group(__DIR__ . '/productRoutes.php');
    Route::prefix('admin')->group(__DIR__ . '/categoryRoutes.php');
});