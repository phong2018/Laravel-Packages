<?php
use Illuminate\Support\Facades\Route;   

use Phonglg\LaravelAuthGithub\Controllers\Auth\GithubController;  

Route::group(['middleware' => ['web']], function () { 

    Route::get('/github/redirect', [GithubController::class, 'redirect'])->name('github.redirect');
    Route::get('/github/callback', [GithubController::class, 'callback'])->name('github.callback');

    Route::get('/github/loginPage', function () {
        return "<a href='".route('github.redirect')."'>login</a>";
    });

});
