<?php

namespace Phonglg\LaravelVeso\Controllers\Testing;

use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Phonglg\LaravelVeso\Helpers\Province;
use Phonglg\LaravelVeso\Models\Order;
use Phonglg\LaravelVeso\Models\Orderdetail; 
use Illuminate\Support\Facades\Gate;
use Phonglg\LaravelVeso\Helpers\Vietlott;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

use Phonglg\LaravelAuth\Models\UserLog;
use Phonglg\LaravelVeso\Models\Vesoproduct;
use Illuminate\Support\Facades\Notification;
use Phonglg\LaravelHtmlDomParser\Models\Prize;
use Phonglg\LaravelLayout\Helpers\NumberHelper;
use Phonglg\LaravelVeso\Notifications\WinPrizeNotifications;
use Phonglg\LaravelVeso\Services\WinPrizeServices;

class WinPrizeTestController extends Controller
{   
    // http://localhost/demoWinPrize
    public function demoWinPrize(){ 

        $service= new WinPrizeServices();
        $prize=Prize::find(3828);//mega
        $service->CheckWinPrize($prize);

        // $prize=Prize::find(3725);//power
        // $service->CheckWinPrize($prize);

        // $prize=Prize::find(3943);//max3d
        // $service->CheckWinPrize($prize);

        // $prize=Prize::find(3726);//max3dpro
        // $service->CheckWinPrize($prize);
         
        // $prize=Prize::find(3877);//keno 
        // $service->CheckWinPrize($prize);
        // $prize=Prize::find(3880);//keno 
        // $service->CheckWinPrize($prize);
        // $prize=Prize::find(3882);//keno 
        // $service->CheckWinPrize($prize);

        // $prize=Prize::find(3889);//keno 
        // $service->CheckWinPrize($prize);
        
    } 
    // update agency_id for order_detal;
    public function testWinPrize2(){
        $orderDetails=Orderdetail::all();
        foreach($orderDetails as $orderDetail){ 
            $details=json_decode($orderDetail->details);  
            if(isset($details->agency_id))
            $orderDetail->update(['agency_id'=>$details->agency_id]);
        } 
    }

    public function testWinPrize1(){
        // #475 3D Pro -> 25/11 kỳ #00032
        $orderId=475;
        $orderDetails=Orderdetail::where('order_id',$orderId)->get();
        foreach($orderDetails as $orderDetail){
            $details_key='max3dpro#00032';
            $details=json_decode($orderDetail->details); 
            $details->specificPeriods=["#00032 | 25-11-2021"];
            $details->winPrizes=null;
            $orderDetail->update(['details_key'=>$details_key,'details'=>json_encode($details)]);
        } 


        $prize=Prize::find(2078); 
        (new WinPrizeServices())->CheckWinPrize($prize); 
    }

    // http://localhost/testWinPrize
    public function testWinPrize(){

 
        // mega 
        $orderId=380;
        $orderDetails=Orderdetail::where('order_id',$orderId)->get();
        foreach($orderDetails as $orderDetail){
            $details_key='mega645#00825';
            $details=json_decode($orderDetail->details); 
            $details->specificPeriods=["#00825 | 19-12-2021"];
            $details->winPrizes=null; 
            $details->winPrizeStatus=null;
            $details->winPrizePeriodStatus=null;
            $orderDetail->update(['details_key'=>$details_key,'details'=>json_encode($details)]);
        }  

        $prize=Prize::find(4548); 
        (new WinPrizeServices())->CheckWinPrize($prize);

        // power
        $orderId=384;
        $orderDetails=Orderdetail::where('order_id',$orderId)->get();
        foreach($orderDetails as $orderDetail){
            $details_key='power655#00662';
            $details=json_decode($orderDetail->details); 
            $details->specificPeriods=["#00662 | 21-12-2021"];
            $details->winPrizes=null;
            $details->winPrizeStatus=null;
            $details->winPrizePeriodStatus=null;
            $orderDetail->update(['details_key'=>$details_key,'details'=>json_encode($details)]);
        }  

        $prize=Prize::find(4752); 
        (new WinPrizeServices())->CheckWinPrize($prize);

         // max3d
         $orderId=386;
         $orderDetails=Orderdetail::where('order_id',$orderId)->get();
         foreach($orderDetails as $orderDetail){
             $details_key='max3d#00396';
             $details=json_decode($orderDetail->details); 
             $details->specificPeriods=["#00396 | 20-12-2021"];
             $details->winPrizes=null;
             $details->winPrizeStatus=null;
             $details->winPrizePeriodStatus=null;
             $orderDetail->update(['details_key'=>$details_key,'details'=>json_encode($details)]);
         }  
         // max3dplus
         $orderId=387;
         $orderDetails=Orderdetail::where('order_id',$orderId)->get();
         foreach($orderDetails as $orderDetail){
             $details_key='max3dplus#00396';
             $details=json_decode($orderDetail->details); 
             $details->specificPeriods=["#00396 | 20-12-2021"];
             $details->winPrizes=null;
             $details->winPrizeStatus=null;
             $details->winPrizePeriodStatus=null;
             $orderDetail->update(['details_key'=>$details_key,'details'=>json_encode($details)]);
         }  

         $prize=Prize::find(4663); 
         (new WinPrizeServices())->CheckWinPrize($prize); 

          // max3dpro
          $orderId=388;
          $orderDetails=Orderdetail::where('order_id',$orderId)->get();
          foreach($orderDetails as $orderDetail){
              $details_key='max3dpro#00043';
              $details=json_decode($orderDetail->details); 
              $details->specificPeriods=["#00043 | 21-12-2021"];
              $details->winPrizes=null;
              $details->winPrizeStatus=null;
              $details->winPrizePeriodStatus=null;
              $orderDetail->update(['details_key'=>$details_key,'details'=>json_encode($details)]);
          } 

          
          $prize=Prize::find(4753); 
         (new WinPrizeServices())->CheckWinPrize($prize); 

         // #475 3D Pro -> 25/11 kỳ #00032
         $orderId=475;
         $orderDetails=Orderdetail::where('order_id',$orderId)->get();
         foreach($orderDetails as $orderDetail){
             $details_key='max3dpro#00032';
             $details=json_decode($orderDetail->details); 
             $details->specificPeriods=["#00032 | 25-11-2021"];
             $details->winPrizes=null;
             $details->winPrizeStatus=null;
             $details->winPrizePeriodStatus=null;
             $orderDetail->update(['details_key'=>$details_key,'details'=>json_encode($details)]);
         } 

         
         $prize=Prize::find(2078); 
        (new WinPrizeServices())->CheckWinPrize($prize); 

          // keno
          $orderId=389 ;
          $orderDetails=Orderdetail::where('order_id',$orderId)->get();
          foreach($orderDetails as $orderDetail){
              $details_key='keno#077265';
              $details=json_decode($orderDetail->details); 
              $details->specificPeriods=["#077265 | 22-12-2021 11:00"];  
              $details->winPrizes=null;
              $details->winPrizeStatus=null;
              $details->winPrizePeriodStatus=null;
              $orderDetail->update(['details_key'=>$details_key,'details'=>json_encode($details)]);
          }  

          $prize=Prize::find(4819); 
          (new WinPrizeServices())->CheckWinPrize($prize); 

          // keno
          $orderId=406;
          $orderDetails=Orderdetail::where('order_id',$orderId)->get();
          foreach($orderDetails as $orderDetail){
              $details_key=str_replace('##','#', $orderDetail->details_key);
              $details=json_decode($orderDetail->details);  
              $details->winPrizes=null;
              $details->winPrizeStatus=null;
              $details->winPrizePeriodStatus=null;
              $orderDetail->update(['details_key'=>$details_key,'details'=>json_encode($details)]);
          }  

          for($i=4904;$i<=4914;$i++){
            $prize=Prize::find($i); 
            (new WinPrizeServices())->CheckWinPrize($prize); 
           }

           // keno
           $orderId=412;
           $orderDetails=Orderdetail::where('order_id',$orderId)->get();
           foreach($orderDetails as $orderDetail){
               $details_key=str_replace('##','#', $orderDetail->details_key);
               $details=json_decode($orderDetail->details);  
               $details->winPrizes=null;
               $details->winPrizeStatus=null;
               $details->winPrizePeriodStatus=null;
               $orderDetail->update(['details_key'=>$details_key,'details'=>json_encode($details)]);
           }  
 
           for($i=4918;$i<=4932;$i++){
            $prize=Prize::find($i); 
            (new WinPrizeServices())->CheckWinPrize($prize); 
           }
            
          
          //vethuong
          $orderId=391 ;
          $orderDetails=Orderdetail::where('order_id',$orderId)->get();
          foreach($orderDetails as $orderDetail){
              $details_key='20211215dnai';
              $details=json_decode($orderDetail->details); 
              $details->prize_date="15-12-2021";  
              $details->winPrizes=null;
              $details->winPrizeStatus=null;
              $details->winPrizePeriodStatus=null;
              $orderDetail->update(['details_key'=>$details_key,'details'=>json_encode($details)]);
          }  

          //capnguyen
          $orderId=392 ;
          $orderDetails=Orderdetail::where('order_id',$orderId)->get();
          foreach($orderDetails as $orderDetail){
              $details_key='20211215dnai';
              $details=json_decode($orderDetail->details); 
              $details->prize_date="15-12-2021";  
              $details->winPrizes=null;
              $details->winPrizeStatus=null;
              $details->winPrizePeriodStatus=null;
              $orderDetail->update(['details_key'=>$details_key,'details'=>json_encode($details)]);
          }  

          $prize=Prize::find(4129); 
          (new WinPrizeServices())->CheckWinPrize($prize); 
          
           //vethuong
           $orderId=464 ;
           $orderDetails=Orderdetail::where('order_id',$orderId)->get();
           foreach($orderDetails as $orderDetail){
               $details_key=$orderDetail->details_key;
               $details=json_decode($orderDetail->details); 
               $details->prize_date="22-12-2021";  
               $details->winPrizes=null;
               $details->winPrizeStatus=null;
               $details->winPrizePeriodStatus=null;
               $orderDetail->update(['details_key'=>$details_key,'details'=>json_encode($details)]);
           }  

           $prize=Prize::find(4849); 
          (new WinPrizeServices())->CheckWinPrize($prize); 
          $prize=Prize::find(4850); 
          (new WinPrizeServices())->CheckWinPrize($prize); 
          $prize=Prize::find(4851); 
          (new WinPrizeServices())->CheckWinPrize($prize); 
           
         
        
    } 

    public function test_vethuongPrize(){
        // [["255738"],["91117"],["41376"],["59093","92198"],["07457","51903","43742","70880","21710","43992","80708"],["6200"],["7658","7771","1539"],["002"],["39"]];
        $prize=Prize::find(3925);//traditionnal 
        $numTicket=['xxxx38'];//vethuong
        $gameType='vethuong';//capnguyen
        $orderDetailId=1;
        //$numTicket=["255738","x91117","x41376","x59093","x07457","xx6200","xx7658","xxx002","xxxx39",'x55738','255x38','xxxx38','xxx738','xx5738'];//vethuong
        //$numTicket=["255738","x91117","x41376","x59093","x07457","xx6200","xx7658","xxx002","xxxx39",'x55738','255x38','xxxx38','xxx738','xx5738'];//capnguyen
        for($i=0;$i<count($numTicket);$i++){
            $orderDetail=Orderdetail::find($orderDetailId);  
            $details=json_decode($orderDetail->details);
            $details->name=$numTicket[$i].'|dthap';
            $details->game_type=$gameType;
            $details->winPrizes=null;
            $orderDetail->update(['details_key'=>'20211213dthap','details'=>json_encode($details)]);
            $service= new WinPrizeServices();
            $service->CheckWinPrize($prize);

            $orderDetail=Orderdetail::find(1);  
            $details=json_decode($orderDetail->details);
            if(isset($details->winPrizes))
            dump('test_vethuongPrize: SUCCESS '.$numTicket[$i], $details->winPrizes);
            else dump('test_vethuongPrize: FAIL '.$numTicket[$i], $details->winPrizes);
        }
    } 
    public function test_mega645Prize(){  
        //["16","21","29","40","41","43"]
        $prize=Prize::find(3828);//mega 
        
        $numTickets=[
            [null,[16,21,29,40,41]],
            [null,[-1,21,29,40,41]],
            [null,[-1,-1,29,40,41]],
            [null,[-1,-1,-1,40,41]],
        ]; 
        for($i=0;$i<count($numTickets);$i++){
            $orderDetail=Orderdetail::find(4);  
            $details=json_decode($orderDetail->details);
            $details->methodSelected=1;
            $details->blocksNumber=$numTickets[$i]; 
            $details->winPrizes=null;
            $details_key=str_replace("##","#",$orderDetail->details_key);
            $orderDetail->update(['details'=>json_encode($details),'details_key'=>$details_key]);
            $service= new WinPrizeServices();
            $service->CheckWinPrize($prize);

            $orderDetail=Orderdetail::find(4);  
            $details=json_decode($orderDetail->details);
            if(isset($details->winPrizes))
            dump('test_mega645Prize: SUCCESS ', $details->winPrizes);
            else dump('test_mega645Prize: FAIL ',$details->winPrizes);
        }
    } 
}
?>