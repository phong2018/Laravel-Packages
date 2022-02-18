<?php

use Phonglg\LaravelVeso\Controllers\Admin\AdminPointController;
use Illuminate\Support\Facades\Route; 

/* Add AdminOrderController routes */  
Route::get('/point/list/{fromDate?}/{toDate?}', [AdminPointController::class, 'index'])->name('admin.point');  
Route::get('/point/{order}', [AdminPointController::class, 'show'])->name('admin.point.show');   
Route::post('/updateOrderAddPoint', [AdminPointController::class, 'updateOrderAddPoint'])->name('admin.updateOrderAddPoint');
Route::post('/updateOrderWithdrawPoint', [AdminPointController::class, 'updateOrderWithdrawPoint'])->name('admin.updateOrderWithdrawPoint');

Route::get('/indexOrderWithdrawPointAccumulate', [AdminPointController::class, 'indexOrderWithdrawPointAccumulate'])->name('admin.indexOrderWithdrawPointAccumulate');
Route::post('/updateOrderWithdrawPointAccumulate', [AdminPointController::class, 'updateOrderWithdrawPointAccumulate'])->name('admin.updateOrderWithdrawPointAccumulate');
 

 