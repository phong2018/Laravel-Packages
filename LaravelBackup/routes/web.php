<?php
use Illuminate\Support\Facades\Route;   
use Phonglg\LaravelBackup\Controllers\BackupController;
 

Route::group(['middleware' => ['web']], function () { 
    Route::get('backup', [BackupController::class, 'index'])->name('backup.index');
    Route::get('backup/create', [BackupController::class, 'create'])->name('backup.create');
    Route::get('backup/download/{disk}/{file_name}', [BackupController::class, 'download'])->name('backup.download');
    Route::get('backup/delete/{disk}/{file_name}', [BackupController::class, 'delete'])->name('backup.delete');
});
 