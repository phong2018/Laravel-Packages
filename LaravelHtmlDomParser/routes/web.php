<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web']], function () {  
    Route::prefix('')->group(__DIR__ . '/drawXosoRoutes.php');
    Route::prefix('')->group(__DIR__ . '/showXosoRoutes.php'); 
});