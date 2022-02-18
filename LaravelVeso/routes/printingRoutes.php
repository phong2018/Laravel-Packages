<?php

use Illuminate\Support\Facades\Route;
use Phonglg\LaravelVeso\Controllers\PrintingController;

Route::get('/printingMienNam/{prize_period?}/{numberPrint?}', [PrintingController::class, 'printingMienNam'])->name('printing.miennam'); 
Route::get('/printingMienTrung/{prize_period?}/{numberPrint?}', [PrintingController::class, 'printingMienTrung'])->name('printing.mientrung'); 
Route::get('/printingMienBac/{prize_period?}/{numberPrint?}', [PrintingController::class, 'printingMienBac'])->name('printing.mienbac'); 
Route::get('/printingMega645/{prize_period?}/{numberPrint?}', [PrintingController::class, 'printingMega645'])->name('printing.mega645'); 
Route::get('/printingPower655/{prize_period?}/{numberPrint?}', [PrintingController::class, 'printingPower655'])->name('printing.power655'); 
Route::get('/printingMax3D/{prize_period?}/{numberPrint?}', [PrintingController::class, 'printingMax3D'])->name('printing.max3d');  
Route::get('/printingMax3DPro/{prize_period?}/{numberPrint?}', [PrintingController::class, 'printingMax3DPro'])->name('printing.max3dpro');  


 