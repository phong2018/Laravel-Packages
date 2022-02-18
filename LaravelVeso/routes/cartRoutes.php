<?php

use Phonglg\LaravelVeso\Controllers\CartController;
use Illuminate\Support\Facades\Route; 

/* Add Product routes */ 
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/cart/store/{product}', [CartController::class, 'store'])->name('cart.store');
Route::post('/cart/storevietlott', [CartController::class, 'storevietlott'])->name('cart.storevietlott');
Route::post('/cart/storeTraditional', [CartController::class, 'storeTraditional'])->name('cart.storeTraditional');
Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/updateQtyCart', [CartController::class, 'updateQtyCart'])->name('cart.updateQtyCart');
Route::delete('/cart/delete', [CartController::class, 'delete'])->name('cart.delete'); 


 