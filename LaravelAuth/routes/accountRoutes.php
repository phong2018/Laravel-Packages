<?php
use Illuminate\Support\Facades\Route;   
use Phonglg\LaravelAuth\Controllers\Auth\AccountController;   
  
Route::get('/account/edit', [AccountController::class, 'edit'])->name('account.edit');
Route::put('/account', [AccountController::class, 'update'])->name('account.update');
Route::get('/account/LogsList', [AccountController::class, 'LogsList'])->name('account.LogsList');
Route::get('/account/customerList', [AccountController::class, 'customerList'])->name('account.customerList');



