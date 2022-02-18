<?php
use Illuminate\Support\Facades\Route;    
use Phonglg\LaravelEventsListeners\Events\WelcomeUser;

// test package
Route::get('/laraveleventslisteners', function () {
    return "laravel laraveleventslisteners";
});

// call event and transfer parameter, for listener listen and run code
Route::get('/callEventWelcomeUser', function () { 
    event(new WelcomeUser('Welcome you come to Website'));
    echo 'listener SendEmailWelcome';
}); 
