<?php

use Phonglg\LaravelVeso\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Phonglg\LaravelVeso\Controllers\Admin\AdminOrderController;

/* Add Product routes */  
Route::post('/order/store', [OrderController::class, 'store'])->name('order.store'); 
Route::get('/order/vnpay_payOrder/{order}', [OrderController::class, 'vnpay_payOrder'])->name('order.vnpay_payOrder'); 
Route::get('/order/vnpay_return', [OrderController::class, 'vnpay_return'])->name('order.vnpay_return'); 
Route::get('/order/thantai39_return', [OrderController::class, 'thantai39_return'])->name('order.thantai39_return'); 
Route::post('/order/uploadFileOrderDetail', [OrderController::class, 'uploadFileOrderDetail'])->name('order.uploadFileOrderDetail'); 

 


 