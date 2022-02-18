<?php
use Illuminate\Support\Facades\Route;  

Route::group(['middleware' => ['web']], function () {   
    Route::prefix('')->group(__DIR__ . '/reactRoutes.php'); 
    Route::prefix('')->group(__DIR__ . '/chessRoutes.php'); 
}); 