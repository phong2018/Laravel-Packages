<?php 
use Illuminate\Support\Facades\Route;
use Phonglg\LaravelLayout\Controllers\CaptchaController;

Route::get('/refresh-captcha', [CaptchaController::class, 'refreshCaptcha']);
 