<?php
use Illuminate\Support\Facades\Route;
use Phonglg\LaravelVnPay\Controllers\VnpayController;
use Phonglg\LaravelVnPay\Controllers\VnpayinpController;

// use for app cotuong
Route::get('/LaravelVnPay', function () {
    return "laravel LaravelVnPay";
});


Route::group(['middleware' => ['web']], function () {   
    Route::get('/vnpay', [VnpayController::class, 'index'])->name('vnpay.index'); 
    Route::post('/vnpay_create_payment', [VnpayController::class, 'vnpay_create_payment'])->name('vnpay.vnpay_create_payment'); 
    Route::get('/vnpay_return', [VnpayController::class, 'vnpay_return'])->name('vnpay.vnpay_return');  


    // only use this route 
    Route::get('/vnpay_ipn', [VnpayinpController::class, 'vnpay_ipn'])->name('vnpay.vnpay_ipn'); 

    Route::post('/vnpay_query', [VnpayController::class, 'vnpay_query'])->name('vnpay.vnpay_query'); 
    Route::get('/vnpay_query_form', [VnpayController::class, 'vnpay_query_form'])->name('vnpay.vnpay_query_form'); 
    Route::post('/vnpay_refund', [VnpayController::class, 'vnpay_refund'])->name('vnpay.vnpay_refund'); 
    Route::get('/vnpay_refund_form', [VnpayController::class, 'vnpay_refund_form'])->name('vnpay.vnpay_refund_form'); 
});
