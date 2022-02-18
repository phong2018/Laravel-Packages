<?php
use Illuminate\Support\Facades\Route;
use Phonglg\LaravelQueues\Jobs\SendEmailUsingQueue;
use Phonglg\LaravelQueues\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail; 

// use for app cotuong
Route::get('/laravelqueues', function () {
    return "laravel laravelqueues";
});


Route::group(['middleware' => ['web']], function () {   
    // send email normal Synchronous
    Route::get('/SendEmailSynchronous', function () { 
        Mail::to(auth()->user()->email)->send(new WelcomeMail('Demo Send email normal Synchronous about 5s'));
        echo 'SendEmailSynchronous email success';
    });

    // send email Using Queue page load immediately
    Route::get('/SendEmailUsingQueue', function () {
        SendEmailUsingQueue::dispatch(auth()->user());
        echo 'SendEmailUsingQueue email success';
    });
    
}); 

