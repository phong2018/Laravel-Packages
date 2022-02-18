<?php
use Illuminate\Support\Facades\Route;  

Route::group(['middleware' => ['web']], function () {   
    Route::prefix('')->group(__DIR__ . '/vueRoutes.php');  
}); 