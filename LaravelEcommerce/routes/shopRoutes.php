<?php

use Phonglg\LaravelEcommerce\Controllers\ShopController;
use Illuminate\Support\Facades\Route;
 
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index'); 


 