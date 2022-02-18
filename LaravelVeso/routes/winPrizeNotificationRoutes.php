<?php
 
use Illuminate\Support\Facades\Route;
use Phonglg\LaravelVeso\Controllers\WinPrizeController;

/* Add Product routes */  
Route::get('/winPrizeNotification/list', [WinPrizeController::class, 'list'])->name('winPrizeNotification.list');  

Route::get('/winPrizeNotification/show/{notification}', [WinPrizeController::class, 'show'])->name('winPrizeNotification.show');  

// Route::get('/sendWinPrizeNotification', [WinPrizeController::class, 'send'])->name('showWinPrize.sendWinPrizeNotification');  

 