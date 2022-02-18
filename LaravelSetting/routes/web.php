<?php
use Illuminate\Support\Facades\Route;   

Route::group(['middleware' => ['web','auth']], function () {  
    Route::prefix('admin')->group(__DIR__ . '/settingRoutes.php'); 
});