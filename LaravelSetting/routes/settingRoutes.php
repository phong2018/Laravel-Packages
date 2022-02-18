<?php

use Phonglg\LaravelSetting\Controllers\SettingController;
use Illuminate\Support\Facades\Route;
 
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::get('/settings/create', [SettingController::class, 'create'])->name('settings.create');
Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
Route::get('/settings/{setting}', [SettingController::class, 'edit'])->name('settings.show');
Route::get('/settings/{setting}/edit', [SettingController::class, 'edit'])->name('settings.edit');
Route::put('/settings/{setting}', [SettingController::class, 'update'])->name('settings.update');
Route::delete('/settings/{setting}', [SettingController::class, 'destroy'])->name('settings.destroy');
 
Route::get('/resetPointCustomer', [SettingController::class, 'resetPointCustomer'])->name('settings.resetPointCustomer');