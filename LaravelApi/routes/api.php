   
<?php
 
 use Illuminate\Support\Facades\Route;
 use Phonglg\LaravelApi\Controllers\Api\ApiAuthController;
 
 Route::group(['middleware' => ['api']], function () {
 
     //public route
     Route::get('/api/publicRoute', function () {
         return array('xinchao' => 'Hello World PUBLIC ROUTE');
     })->name('api.publicRoute');
 
     Route::post('/api/register', [ApiAuthController::class, 'register'])->name('api.register');
     Route::post('/api/login', [ApiAuthController::class, 'login'])->name('api.login');
 
 
     //protected Route by auth:sanctum 
     Route::group(['middleware' => ['auth:sanctum']], function () {
         Route::get('/api/protectedRoute', function () {
             return array('xinchao' => 'Hello World PROTECTED ROUTE');
         })->name('api.protectedRoute');
         
         Route::post('/api/logout', [ApiAuthController::class, 'logout'])->name('api.logout');
     });
 });
 
 
 