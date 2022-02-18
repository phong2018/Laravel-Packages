<?php
use Illuminate\Support\Facades\Route;
use Phonglg\LaravelAuth\Controllers\Auth\ForgotController;
use Phonglg\LaravelAuth\Controllers\Auth\RegisterController;
use Phonglg\LaravelAuth\Controllers\Auth\LoginController;
use Phonglg\LaravelAuth\Controllers\Auth\LogoutController; 

Route::get('/admin', [LoginController::class, 'index'])->name('admin');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');
Route::post('/login', [LoginController::class, 'store']);
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']); 

// forgot password
Route::get('/forgot-password', [ForgotController::class, 'index'])->name('password.forgot');
Route::post('/request-password', [ForgotController::class, 'request'])->name('password.request');
Route::get('/reset-password/{token}', [ForgotController::class, 'reset'])->name('password.reset');
Route::post('/store-passwod', [ForgotController::class, 'store'])->name('password.store');
 

 