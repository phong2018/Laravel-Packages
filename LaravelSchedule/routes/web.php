<?php
use Illuminate\Support\Facades\Route; 
use Illuminate\Support\Facades\Log;

// use for app cotuong
Route::get('/LaravelSchedule', function () {
    return "laravel LaravelSchedule";
});

// use for app cotuong
Route::get('/DemoLogFile', function () {
    Log::debug('DemoLogFile An informational message.');
});


