<?php
 
use Illuminate\Support\Facades\Route; 

use Illuminate\Support\Facades\Artisan; 


 
Route::get('/testTest', function () {
    return ['hllo'];
});
 
Route::get('/LaravelVeso', function () {
    return "laravel LaravelVeso";
});

Route::get('symbolicLink', function(){
    Artisan::call('storage:link', []);
    return 'success';
});

Route::group(['middleware' => ['web']], function () {
    // route
    Route::prefix('')->group(__DIR__ . '/jobRoutes.php');  
    Route::prefix('')->group(__DIR__ . '/buyLotteryRoutes.php');  
    Route::prefix('')->group(__DIR__ . '/printingRoutes.php');  
    Route::prefix('')->group(__DIR__ . '/cartRoutes.php');
    Route::prefix('')->group(__DIR__ . '/orderRoutes.php');
    Route::prefix('')->group(__DIR__ . '/webhookRoutes.php');
    Route::prefix('')->group(__DIR__ . '/eventsRoutes.php');
}); 

Route::group(['middleware' => ['web','auth']], function () {  
    // customer
    Route::prefix('')->group(__DIR__ . '/pointRoutes.php');
    Route::prefix('')->group(__DIR__ . '/customerOrderRoutes.php');
    Route::prefix('')->group(__DIR__ . '/winPrizeNotificationRoutes.php');
    Route::prefix('')->group(__DIR__ . '/testingRoutes.php');
    Route::prefix('')->group(__DIR__ . '/vesoproductRoutes.php'); 
    // report ruote
    Route::prefix('')->group(__DIR__ . '/reportRoutes.php'); 
    // agency
    Route::prefix('')->group(__DIR__ . '/agencyOrderRoutes.php');
    // admin | employee
    Route::prefix('admin')->group(__DIR__ . '/adminOrderRoutes.php');
    Route::prefix('admin')->group(__DIR__ . '/adminPointRoutes.php');
    
});
 





 