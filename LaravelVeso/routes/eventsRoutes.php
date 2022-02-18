<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Phonglg\LaravelVeso\Jobs\MonitorPrintTicketJob;
use Phonglg\LaravelVeso\Events\PaidOrderSuccess;
use Phonglg\LaravelVeso\Events\PrintTicketSuccess;

/* Add Product routes */  
Route::get('/callPaidOrderSuccess', function () {
    event(new PaidOrderSuccess(89));

    // echo strtotime("2021-11-12 10:00:00")."<br>";
    // echo strtotime("2021-11-12 11:00:00")."<br>";
    // echo strtotime("2021-11-12 12:00:00")."<br>";
    // echo strtotime("2021-11-12 01:00:00")."<br>";
   
    // echo 'time(): '.time().'<br>';
    // echo 'now(): '.now().'<br>';
    // echo "date('Y-m-d H:i:s'): ".date('Y-m-d H:i:s').'<br>';
    // echo "date('Y-m-d 05:07'): ".date('Y-m-d 05:07').'<br>';
    // echo 'strtotime(now()): '.strtotime(now()).'<br>';  
    // echo 'strtotime("+1 day", strtotime(now())): '.strtotime("+1 day", strtotime(now())).'<br>';
    // echo 'strtotime("+10 minutes", strtotime(now())):'.strtotime("+10 minutes", strtotime(now())).'<br>';
    // echo 'date("Y-m-d", strtotime("monday this week")): '.date("Y-m-d", strtotime("monday this week")).'<br>';
    // echo 'date("Y-m-d H:i:s", time()): '.date("Y-m-d H:i:s", time()).'<br>';
    // echo 'date("Y-m-d H:i:s", strtotime(now())): '.date("Y-m-d H:i:s", strtotime(now())).'<br>';
    // echo "date('m',time()): ".date('m',time()).'<br>';
    
    // dd('HLEO');
    // $orderStatus=config('laravelveso.orderStatus'); 
    // $status = $orderStatus['pendding']['key']; 
    // dd($status); 
    
});

Route::get('/callPrintTicketSuccess', function () {
    // dd('HLEO');
    //event(new PrintTicketSuccess('4#0#mega'));
    // event(new PrintTicketSuccess('258#0#power'));
    // event(new PrintTicketSuccess('259#0#max3d'));
    // event(new PrintTicketSuccess('260#0#max3d+'));
    // event(new PrintTicketSuccess('261#0#3dprobasic'));
    // event(new PrintTicketSuccess('262#1#keno'));
    event(new PrintTicketSuccess('5#1#keno'));
});

 