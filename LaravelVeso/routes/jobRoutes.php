<?php
 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelVeso\Jobs\PointJob;

// PointJob
Route::get('/PointJob', function () {
    $message=['id'=>1,'name'=>'phong'];
    PointJob::dispatch($message);
    Log::debug('PointJob dispatch');
    echo 'PointJob dispatch';
});

// call PointJob
Route::get('/callPointJob', function () {
    Artisan::call('queue:retry all', []);  // to tranfer froms jobs to  failed_jobs
    Artisan::call('queue:work --tries=1 --stop-when-empty', []); 
});   
