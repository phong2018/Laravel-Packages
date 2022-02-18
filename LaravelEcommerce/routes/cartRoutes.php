<?php

use Phonglg\LaravelEcommerce\Controllers\CartController;
use Illuminate\Support\Facades\Route; 

/* Add Product routes */ 
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/cart/store/{product}', [CartController::class, 'store'])->name('cart.store');
Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/delete', [CartController::class, 'delete'])->name('cart.delete'); 


 