<?php
 
use Phonglg\LaravelPost\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);
Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('aboutUs');
Route::get('/search', [HomeController::class, 'search'])->name('search');