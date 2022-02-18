<?php

namespace Phonglg\LaravelVeso\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelHtmlDomParser\Models\Prize;
use Phonglg\LaravelLayout\Helpers\Date;
use Phonglg\LaravelVeso\Models\Orderdetail;
use Phonglg\LaravelVeso\Services\WinPrizeServices;

class TestingHelpers
{
    public static function test(){
        Log::debug('test: Yes');
    }

    public static function test_vethuongPrize(){
        // [["255738"],["91117"],["41376"],["59093","92198"],["07457","51903","43742","70880","21710","43992","80708"],["6200"],["7658","7771","1539"],["002"],["39"]];
        $prize=Prize::find(3925);//traditionnal 
        $numTicket=['xxxx38'];//vethuong
        $gameType='vethuong';//capnguyen
        $orderDetailId=1;//traditional
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
                Log::debug('.......test_vethuongPrize: Yes ');
            else Log::debug('_____test_vethuongPrize: No ');
        }
    } 
    public static function test_mega645Prize(){  
        //["16","21","29","40","41","43"]
        $prize=Prize::find(3828);//mega 
        
        $numTickets=[
            [null,[16,21,29,40,41]],
            [null,[-1,21,29,40,41]],
            [null,[-1,-1,29,40,41]],
            [null,[-1,-1,-1,40,41]],
        ]; 
        $orderDetailId=3;//mega
        $detailsKey='mega645#00822'; 
        for($i=0;$i<count($numTickets);$i++){
            $orderDetail=Orderdetail::find($orderDetailId);  
            $details=json_decode($orderDetail->details);
            $details->methodSelected=1;
            $details->blocksNumber=$numTickets[$i]; 
            $details->winPrizes=null;  
            $orderDetail->update(['details'=>json_encode($details),'details_key'=>$detailsKey]);
            $service= new WinPrizeServices();
            $service->CheckWinPrize($prize);

            $orderDetail=Orderdetail::find($orderDetailId);  
            $details=json_decode($orderDetail->details);
            if(isset($details->winPrizes))
            Log::debug('.......test_mega645Prize: Yes ');
            else Log::debug('______test_mega645Prize: No ');
        }
    } 

}