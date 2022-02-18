<?php 
use Illuminate\Support\Facades\Route; 
use Phonglg\LaravelLayout\Controllers\DemoController;
 

// Demo use axios
Route::get('/getMethod', [DemoController::class, 'getMethod'])->name('getMethod');
Route::post('/postMethod', [DemoController::class, 'postMethod'])->name('postMethod');
Route::post('/postInputsMethod', [DemoController::class, 'postInputsMethod'])->name('postInputsMethod');

Route::get('/useAjaxDemo', function () { return view('laravellayout::demo.useAjaxDemo');}); 
Route::get('/useAxiosDemo', function () { return view('laravellayout::demo.useAxiosDemo');}); 
Route::get('/useAxiosInputsDemo', function () { return view('laravellayout::demo.useAxiosInputsDemo');}); 

  