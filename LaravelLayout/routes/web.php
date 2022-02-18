<?php
use Illuminate\Support\Facades\Route;  
use Phonglg\LaravelLayout\Controllers\DashboardController;
use Phonglg\LaravelLayout\Controllers\HomeController;

Route::group(['middleware' => ['web']], function () {  
    // route demo function
    Route::prefix('')->group(__DIR__ . '/demoRoutes.php');

    // route demo axios
    Route::prefix('')->group(__DIR__ . '/useAxios.php');

    // route test layout
    Route::prefix('')->group(__DIR__ . '/layoutRoutes.php');

    // route test react
    Route::prefix('')->group(__DIR__ . '/reactRoutes.php');

    // route captchar
    Route::prefix('')->group(__DIR__ . '/captchaRoutes.php');

    //laravel Filemanager use for: http://127.0.0.1/laravel-filemanager/demo
    // Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    //     \UniSharp\LaravelFilemanager\Lfm::routes();
    // });  

}); 


// page domain home
Route::group(['middleware' => ['web']], function () {   
    Route::get('/results/{date}', [HomeController::class, 'results'])->name('resultDate'); 
});

// Route for dashboard page
Route::group(['middleware' => ['web','auth','adminMiddleware']], function () {  
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); 
});

