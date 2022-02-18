<?php 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Crypt; 

// Demo use crypt
Route::get('/viewdemo', function () {
    echo base_path().'<br>';
    $crypt=Crypt::encryptString('HELO');
    echo $crypt.'<br>';
    echo  Crypt::decryptString($crypt); 
}); 
 