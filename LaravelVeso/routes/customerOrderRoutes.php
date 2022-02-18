<?php

use Phonglg\LaravelVeso\Controllers\CustomerOrderController;
use Illuminate\Support\Facades\Route; 

/* Add CustomerOrderController routes */  
Route::get('/customer/order', [CustomerOrderController::class, 'index'])->name('customer.order');  
Route::get('/customer/order/{order}', [CustomerOrderController::class, 'show'])->name('customer.order.show');  

 