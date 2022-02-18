<?php

use Phonglg\LaravelUserRole\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
 
Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
Route::get('/agencyList', [CustomerController::class, 'agencyList'])->name('agency.list');
Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
Route::get('/customers/{customer}', [CustomerController::class, 'edit'])->name('customers.show');
Route::get('/customerLog/{customer}', [CustomerController::class, 'customerLog'])->name('customers.customerLog');
Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
 