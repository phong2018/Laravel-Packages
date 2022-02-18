<?php

use Phonglg\LaravelVeso\Controllers\PointController;
use Illuminate\Support\Facades\Route;

/* Add point routes */  
Route::get('/point', [PointController::class, 'index'])->name('point.list'); 
Route::get('/point/add', [PointController::class, 'add'])->name('point.add'); 
Route::post('/point/store', [PointController::class, 'store'])->name('point.store'); 

Route::get('/point/withdraw', [PointController::class, 'withdraw'])->name('point.withdraw'); 
Route::post('/point/withdraw/store', [PointController::class, 'withdrawStore'])->name('point.withdraw.store'); 


Route::get('/point/withdrawAccumulatePoint', [PointController::class, 'withdrawAccumulatePoint'])->name('point.withdrawAccumulatePoint'); 
Route::post('/point/withdrawAccumulatePoint/store', [PointController::class, 'withdrawAccumulatePointStore'])->name('point.withdrawAccumulatePoint.store'); 


Route::get('/point/success', [PointController::class, 'success'])->name('point.success'); 
Route::get('/point/{order}', [PointController::class, 'show'])->name('point.show');  
