<?php

use Phonglg\LaravelEcommerce\Controllers\OrderController;
use Illuminate\Support\Facades\Route; 

/* Add Product routes */  
Route::get('/order/checkout', [OrderController::class, 'checkout'])->name('order.checkout'); 
Route::post('/order/store', [OrderController::class, 'store'])->name('order.store'); 
Route::get('/order/success', [OrderController::class, 'success'])->name('order.success'); 

 