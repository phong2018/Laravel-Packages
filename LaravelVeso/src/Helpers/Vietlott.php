<?php

namespace Phonglg\LaravelVeso\Helpers;

use App\Models\User;
use Phonglg\LaravelLayout\Helpers\Date;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelSetting\Helpers\SettingHelper;
use Illuminate\Support\Facades\Http;
use Phonglg\LaravelAuth\Models\UserLog; 
use Phonglg\LaravelHtmlDomParser\Models\Prize;
use Phonglg\LaravelVeso\Models\Order;
use Phonglg\LaravelVeso\Models\Orderdetail;
use Phonglg\LaravelVeso\Models\Ticket;

use Illuminate\Support\Facades\Notification;
use Phonglg\LaravelLayout\Helpers\NumberHelper;
use Phonglg\LaravelVeso\Models\Vesoproduct;
use Phonglg\LaravelVeso\Models\WinPrize;
use Phonglg\LaravelVeso\Notifications\WinPrizeNotifications;

class Vietlott
{ 

    // caculatePrizeIndexKenoEvenOdd 15, 13, 11, 10 , 9, 7, 5
    //                               0,  0,  0,  1, 0
    //                               [200000,40000,20000,20000,20000,40000,200000]    
    public static function getPrizeKenoEvenOdd($blocksNumber,$even):array{
      
        $prizeValueEvenOdd=config('laravelhtmldomparser.categoryType.keno.valuePrizes.10'); 
        if($even>=15 && $blocksNumber[0]==1) return [0,$prizeValueEvenOdd[0]];
        if($even>=13 && $even<15 && $blocksNumber[0]==1) return [0,$prizeValueEvenOdd[1]];
        if($even>=11 && $even<13 && $blocksNumber[1]==1) return [1,$prizeValueEvenOdd[2]];
        if($even==10 && $blocksNumber[2]==1) return [2,$prizeValueEvenOdd[3]];
        if($even>7 && $even<=9 && $blocksNumber[3]==1) return [3,$prizeValueEvenOdd[4]];
        if($even>5 && $even<=7 && $blocksNumber[4]==1) return [4,$prizeValueEvenOdd[5]];
        if($even<=5 && $blocksNumber[4]==1) return [4,$prizeValueEvenOdd[6]];
        return [0,0];
    }
    // caculatePrizeIndexKenoBigSmall 13, 11, 10 , 9, 7
    public static function getPrizeKenoBigSmall($blocksNumber,$big){
        $prizeValueBigSmall=config('laravelhtmldomparser.categoryType.keno.valuePrizes.11'); 
        if($big>=13 && $blocksNumber[0]==1) return [0,$prizeValueBigSmall[0]];
        if($big>=11 && $big<13 && $blocksNumber[0]==1) return [0,$prizeValueBigSmall[1]];
        if($big==10 && $blocksNumber[1]==1) return [1,$prizeValueBigSmall[2]];
        if($big>7 && $big<=9 && $blocksNumber[2]==1) return [2,$prizeValueBigSmall[3]];
        if($big<=7 && $blocksNumber[2]==1) return [2,$prizeValueBigSmall[4]]; 
        return [0,0];
    } 

    // getCurrPeriodAllVietlott
    public static function getCurrPeriodAllVietlott(){
        $keyVietlotts=[];
        $keyVietlotts[]=config('laravelhtmldomparser.categoryType.mega645.key');
        $keyVietlotts[]=config('laravelhtmldomparser.categoryType.power655.key');
        $keyVietlotts[]=config('laravelhtmldomparser.categoryType.max3d.key');
        $keyVietlotts[]=config('laravelhtmldomparser.categoryType.max3dpro.key');
        $keyVietlotts[]=config('laravelhtmldomparser.categoryType.keno.key'); 
        $currPeriodAllVietlott=[];
        foreach($keyVietlotts as $keyVietlott){
            $tempLatesPrzize=SettingHelper::getKey(config('laravelhtmldomparser.categoryType.'.$keyVietlott.'.keyLatestResult'));
            $currPeriodAllVietlott[$keyVietlott]=str_replace("#","",$tempLatesPrzize[0]);
        }
        return $currPeriodAllVietlott;

    }
     // getStringOrderDetail
    public static function getStringOrderDetail($orderDetail){
        return config('laravelhtmldomparser.categoryType.'.$orderDetail->category.'.name');
    }

    // getStringWinPrize
    public static function getStringWinPrize($winPrize,$order):string{
        $stringResult='';
        $stringValuePrize=NumberHelper::isNumber($winPrize[1])?number_format($winPrize[1]).'Đ':$winPrize[1];
        switch($winPrize[2]){ 
            
            case config('laravelhtmldomparser.categoryType.miennam.key'):
                $stringResult.=$winPrize[0].' '.config('laravelhtmldomparser.categoryType.miennam.name').' '.$stringValuePrize;
                break; 
            case config('laravelhtmldomparser.categoryType.mientrung.key'):
                $stringResult.=$winPrize[0].' '.config('laravelhtmldomparser.categoryType.mientrung.name').' '.$stringValuePrize;
                break; 
            case config('laravelhtmldomparser.categoryType.mienbac.key'):
                $stringResult.=$winPrize[0].' '.config('laravelhtmldomparser.categoryType.mientrung.name').' '.$stringValuePrize;
                break; 

            case config('laravelhtmldomparser.categoryType.mega645.key'):
                $stringResult.=$winPrize[0].' '.config('laravelhtmldomparser.categoryType.mega645.name').' '.$stringValuePrize;
                break;
            case config('laravelhtmldomparser.categoryType.power655.key'):
                $stringResult.=$winPrize[0].' '.config('laravelhtmldomparser.categoryType.power655.name').' '.$stringValuePrize;
                break;
            case config('laravelhtmldomparser.categoryType.max3d.key'):
                $stringResult.=$winPrize[0].' '.config('laravelhtmldomparser.categoryType.max3d.name').' '.$stringValuePrize;
                break;
            case config('laravelhtmldomparser.categoryType.max3dplus.key'):
                $stringResult.=$winPrize[0].' '.config('laravelhtmldomparser.categoryType.max3dplus.name').' '.$stringValuePrize;
                break;
            case config('laravelhtmldomparser.categoryType.max3dpro.key'):
                $stringResult.=$winPrize[0].' '.config('laravelhtmldomparser.categoryType.max3dpro.name').' '.$stringValuePrize;
                break;
            case config('laravelhtmldomparser.categoryType.keno.key'):
                $stringResult.=config('laravelhtmldomparser.categoryType.keno.name').' '.$stringValuePrize ;
                break;
        } 
        
        if($order) $stringResult.=". <a class='text-blue-500' href='".route('customer.order.show',['order'=>$order])."'>Hóa Đơn #".$order->id."</a>";
        return $stringResult;
    }
    // getKeyForOrderDetail; detail->name: 123456|agiang -> return prize_date.angiang
    public static function getKeyForOrderDetail($detail):string{
        $tempArr=explode('|',$detail->name);
        $key=str_replace("-","",Date::dateDMYtoYMD($detail->prize_date)).$tempArr[1];
        return $key;
    }

    // getOnlyPeriod #00816 | 01-12-202 -> return #00816
    public static function getOnlyPeriod($period):string{
        $tempArr=explode('|',$period);
        $key=trim($tempArr[0]);
        return $key;
    }
    // getPrizesFromDB
    public static function getPrizesFromDB($prizeType,$prize_period,$numRow){
        
        $prizes=Prize::where('category',$prizeType);

        if($prize_period)  $prizes=$prizes->where('prize_period',$prize_period);

        $prizes=$prizes->orderBy('id','DESC');

        if($numRow) $prizes=$prizes->take($numRow)->get();
        else  $prizes=$prizes->get();

        return $prizes;
    }

    //prepareDataTraditionalPrint prize_period is date -> timestamp
    public static function prepareDataTraditionalPrint(string $categoryType, string $prize_period=''):array
    {  
        if($prize_period=='') $prize_period=SettingHelper::getKey(config('laravelhtmldomparser.categoryType.'.$categoryType.'.keyLatestResult')); 
        $prize_period=strtotime($prize_period);

        $tempPrize=Vietlott::getPrizesFromDB($categoryType,$prize_period,false);
        $prizesResult=Vietlott::PrepareDataXoSo($tempPrize);
        return $prizesResult;
    }

    // prepareDataVietlottPrint 
    public static function prepareDataVietlottPrint(string $categoryType, string $prize_period=''):array
    {     
        if($prize_period=='') {
            $latestDatePrize=SettingHelper::getKey(config('laravelhtmldomparser.categoryType.'.$categoryType.'.keyLatestResult'));
            $prize_period= $latestDatePrize[0];
        }     

        $tempPrize=Vietlott::getPrizesFromDB($categoryType,$prize_period,false);
        $prizesResult=Vietlott::PrepareDataXoSo($tempPrize);
       
        return $prizesResult;
    }

    // PrepareDataXoSo
    public static function PrepareDataXoSo($prizes){
        $tempPrize=[];
        foreach($prizes as $no => $prize){
             $tempPrize[]=[
                  'key'=>$prize->key,
                  'province_name'=>$prize->province,
                  'category'=>$prize->category,
                  'prize_ticketType'=>$prize->prize_ticketType,
                  'prize_period'=>$prize->prize_period,
                  'prize_date'=>Carbon::parse($prize->prize_date)->format('d-m-Y'),
                  'prize_date_Ymd'=>$prize->prize_date,
                  'prize_time'=>$prize->prize_time,
                  'prize_number'=>json_decode($prize->prize_number),
                  'prize_value'=>json_decode($prize->prize_value),
                  'prize_name'=>json_decode($prize->prize_name),
                  'prize_quantity'=>json_decode($prize->prize_quantity)                   
             ];
        }; 
        return $tempPrize;
  }
    // getLatestPeriod
    public static function getLatestPeriod($categoryType,$prize_date){
        $latestPeriod=SettingHelper::getKey(config('laravelhtmldomparser.categoryType.'.$categoryType.'.keyLatestResult'));
        $latestPeriod[0]=str_replace('#','',$latestPeriod[0]);
        $lengthPeriod=strlen($latestPeriod[0]); 
        // check had latest period yet, if had -> just get, else +1
        if($prize_date==$latestPeriod[1]) 
            $latestPeriod=$latestPeriod[0]; 
        else{
            $latestPeriod=$latestPeriod[0]; 
            $latestPeriod++;
        } 
        // add # for period
        $latestPeriod='#'.str_pad($latestPeriod, $lengthPeriod, '0', STR_PAD_LEFT);
        return $latestPeriod;
    }

    
    // addPointForCustomerBuyPoint
    public static function updatePointForCustomer($user,$newPoint,$log,$sendNotification=false){ 
        $user->update(['point'=>$newPoint]);
        UserLog::create(['userId'=>$user->id,'log'=>$log]); 
        // send notification for user
        if($sendNotification) Notification::send($user, new WinPrizeNotifications($user,$message=['title'=>$log])); 
        Log::debug('userPoint=',[$newPoint,$log,$user]);
        // log for admin
        // UserLog::create(['userId'=>1,'log'=>$log]); 
    }
    // updatePointInfoForCustomer
    public static function updatePointInfoForCustomer($user,$point,$typePoint){ 
        $user=User::find($user->id);

        if($user->point_info) $pointInfo=(array)json_decode($user->point_info);
        else $pointInfo=[];

        if(isset($pointInfo[$typePoint])) $pointInfo[$typePoint]+=$point;
        else $pointInfo[$typePoint]=$point;

        $user->update(['point_info'=>json_encode($pointInfo)]);
        
        //============log to check Err
        $data=[
            'pointAdd'=>0,
            'pointWithdraw'=>0,
            'pointBuyTicket'=>0,
            'pointRefund'=>0, 
            'pointWinPrize'=>0,
            'pointPaidSaleTicketForAgency'=>0,
            'pointCommissionForPresenter'=>0,
            'pointPaidPrize'=>0
        ];
        $pointInfo=json_decode($user->point_info);
        if(isset($pointInfo->pointAdd))$data['pointAdd']+=$pointInfo->pointAdd;
        if(isset($pointInfo->pointWithdraw))$data['pointWithdraw']+=$pointInfo->pointWithdraw;
        if(isset($pointInfo->pointBuyTicket))$data['pointBuyTicket']+=$pointInfo->pointBuyTicket;
        if(isset($pointInfo->pointRefund))$data['pointRefund']+=$pointInfo->pointRefund;
        if(isset($pointInfo->pointWinPrize))$data['pointWinPrize']+=$pointInfo->pointWinPrize;
        if(isset($pointInfo->pointPaidSaleTicketForAgency))$data['pointPaidSaleTicketForAgency']+=$pointInfo->pointPaidSaleTicketForAgency;  
        if(isset($pointInfo->pointCommissionForPresenter))$data['pointCommissionForPresenter']+=$pointInfo->pointCommissionForPresenter;
        if(isset($pointInfo->pointPaidPrize))$data['pointPaidPrize']+=$pointInfo->pointPaidPrize;
        
        $total=$data['pointAdd']-$data['pointWithdraw']-$data['pointBuyTicket']+$data['pointCommissionForPresenter']+$data['pointRefund']+$data['pointWinPrize']+$data['pointPaidSaleTicketForAgency']-$data['pointPaidPrize'];
        Log::debug('userPointInfo=',[ $total,$pointInfo,$typePoint,$point,$user]);
        if($total!=$user->point) Log::debug('Fail Point=================');
    } 

    // addAccumulatedPointForCustomerBuyAccumulatedPoint
    public static function updateAccumulatedPointForCustomer($user,$newAccumulatedPoint,$log,$sendNotification=false){ 
 
    }
    // updateAccumulatedPointInfoForCustomer
    public static function updateAccumulatedPointInfoForCustomer($user,$point,$typeAccumulatedPoint){ 
   
    }
 
    // caculate totalRefund for detailOrder
    public static function caculateToRefundForDetail($detailOrder){
        $tempRefundTotal=0;
        $traditionallottery=config('laravelhtmldomparser.categoryType.traditionallottery.key');
        $mega645=config('laravelhtmldomparser.categoryType.mega645.key');
        $power655=config('laravelhtmldomparser.categoryType.power655.key');
        $details=(array)json_decode($detailOrder->details);
        if($detailOrder->category==$mega645||$detailOrder->category==$power655)
        $phichoibao=config('laravelhtmldomparser.categoryType.'.$detailOrder->category.'.phichoibao'); 

        // caculate for traditionallottery
        if($detailOrder->category==$traditionallottery){
            if(isset($details['qtyRefund']))$ticketFree=$details['qtyRefund'];else $ticketFree=0;
            if($detailOrder->quantity_refund>0) $tempRefundTotal+=($detailOrder->quantity_refund-$ticketFree)*$detailOrder->price;
        } 
        else{ // caculate for vietlott   
            // dd($detailOrder);
            $periodStatus=$details['periodStatus'];
            $prices=$details['priceBlocks'];  
            $countBlockNumber=0;
            foreach($details['blocksNumber'] as $number) if($number!=null) $countBlockNumber++;
            foreach($periodStatus as $no=>$refund)
            if($refund==0){
                $tempRefundTotal+=$detailOrder->price/count($periodStatus)*$detailOrder->quantity;
            }            
        } 
        return $tempRefundTotal;
    }

    // show periodStatus
    public static function getLayoutForUser(){
        if(auth()->user()->role_id<config('laraveluserrole.defaultRoleId'))
        $template=config('laravelveso.layoutAdmin');
        else $template=config('laravelveso.layoutAgency'); 
        return $template;
    }

    // show periodStatus
    public static function showperiodStatus($status){
        $periodStatus=config('laravelveso.buyingPeriodsStatus');
        // $periodStatus -1, 0, >0
        if($periodStatus['pendding'][0]==$status) return $periodStatus['pendding'][1];
        if($periodStatus['canceled'][0]==$status) return '<span class="text-red-600">'.$periodStatus['canceled'][1].'</span>';
        if($periodStatus['success'][0]==$status) return $periodStatus['success'][1];
    }

    // show periodStatus
    public static function showOrderStatus($status){
        $orderStatus=config('laravelveso.orderStatus');
        // $periodStatus -1, 0, >0
        if($orderStatus['pendding']['key']==$status) return '<span class="text-red-600">'.$orderStatus['pendding']['label'].'</span>'; 
        if($orderStatus['paid']['key']==$status) return '<span class="text-green-600">'.$orderStatus['paid']['label'].'</span>';
        if($orderStatus['failure']['key']==$status) return '<span class="text-blue-600">'.$orderStatus['failure']['label'].'</span>';
        if($orderStatus['success']['key']==$status) return '<span class="text-blue-600">'.$orderStatus['success']['label'].'</span>';
    }

    // tickDetailsKeyVietlott to not get prize again
    public static function tickDetailsKeyVietlott($orderDetail,$keyPrize){        
        $newKeyPrize=str_replace("#",'##',$keyPrize);
        $detailsKey=$orderDetail->details_key;   
        $newDetailsKey=str_replace($keyPrize,$newKeyPrize,$detailsKey);
        $orderDetail->update(['details_key'=>$newDetailsKey]);
    }
        
    // getBuyingPeriodByOrder
    public static function getBuyingPeriodByOrder($numberOfBuyingPeriod){
        $nextPeriods=[];
        for($i=1;$i<=$numberOfBuyingPeriod;$i++)
        $nextPeriods[]='#'.$i;
        return $nextPeriods;
    }

    // combineBlock3D
    public static function combineBlock3D($block){
        if($block){
            $temp=[];
            $temp[]=$block[0].$block[1].$block[2];
            if(isset($block[3]))
            $temp[]=$block[3].$block[4].$block[5];
            return $temp;
        }else return null;
        
    }
    // getKymuaNextBy: $numberOfKymua,$weekdaysHasResult,$timeNotAllowBuy
    public static function getBuyingPeriodsNextBy($categoryType,$numberOfKymua,$weekdaysHasResult,$timeNotAllowBuy){
        $kymuaNext=[]; 
        $currDate=date("Y-m-d");    
        $weekdayCurrDate=Date::getWeekdayFromDate($currDate); 
        $dayRun=$currDate;
        $weekdayRun=Date::getWeekdayFromDate($dayRun); 
        // get latest periods save in setting
        $latestPeriod=SettingHelper::getKey(config('laravelhtmldomparser.categoryType.'.$categoryType.'.keyLatestResult'));
        $latestPeriod[0]=str_replace('#','',$latestPeriod[0]);
        $lengthPeriod=strlen($latestPeriod[0]);
        $timeNotAllowBuy=date("Y-m-d ".$timeNotAllowBuy); // 17:55

        // get latest $numPeriod
        $numPeriod=$latestPeriod[0]; // case normalt get latest period save in setting
        // if have result but not yet get => have to + 1 to => latest period
        if(strtotime(now())>=strtotime($timeNotAllowBuy) && in_array($weekdayCurrDate, $weekdaysHasResult))
        $numPeriod=$latestPeriod[0]+1;

        // get periods next
        while(count($kymuaNext)<$numberOfKymua){
            if(in_array($weekdayRun, $weekdaysHasResult)){// if weekdayRun in weekdaysHasResult
                if($dayRun==$currDate){
                    if(strtotime(now())<strtotime($timeNotAllowBuy)){
                        $numPeriod++;
                        $kymuaNext[]='#'.str_pad($numPeriod, $lengthPeriod, '0', STR_PAD_LEFT).' | '.Carbon::parse($dayRun)->format('d-m-Y');
                    }
                }
                if($dayRun>$currDate){ 
                    $numPeriod++;
                    $kymuaNext[]='#'.str_pad($numPeriod, $lengthPeriod, '0', STR_PAD_LEFT).' | '.Carbon::parse($dayRun)->format('d-m-Y');
                }
            }
            $dayRun=date('Y-m-d', strtotime("+1 day", strtotime($dayRun)));
            $weekdayRun=Date::getWeekdayFromDate($dayRun);
        }

        return $kymuaNext;
    }

    public static function getBuyingPeriodsNext($categoryType,$numberOfBuyingPeriod)
    {
        $kymuaNext=[];   
        $weekdaysHasResult=config('laravelhtmldomparser.categoryType.'.$categoryType.'.weekdays');
        $timeNotAllowBuy=config('laravelhtmldomparser.categoryType.'.$categoryType.'.timeNotAllowBuy');
        $kymuaNext=Vietlott::getBuyingPeriodsNextBy($categoryType,$numberOfBuyingPeriod,$weekdaysHasResult,$timeNotAllowBuy);
        return $kymuaNext;
    }

    public static function findNextPeriodKeno($dateTimeRun){
        // mktime(hour, minute, second, month, day, year)// echo "Created date is " . date("Y-m-d h:i:sa", $d);
        $startDateTime=mktime(6, 0, 0, date('m',strtotime($dateTimeRun)), date('d',strtotime($dateTimeRun)), date('Y',strtotime($dateTimeRun)));
        $endDateTime=mktime(21, 55, 0, date('m',strtotime($dateTimeRun)), date('d',strtotime($dateTimeRun)), date('Y',strtotime($dateTimeRun)));
        // dd(date("Y-m-d H:i:sa", $startDateTime),date("Y-m-d H:i:sa", $endDateTime));
        $minute=date('i',strtotime($dateTimeRun));
        for($i=10;$i<=60;$i=$i+10)
        if($minute<=$i) break;
        $getDateTime=date('Y-m-d H:i', strtotime("+".($i-$minute)." minutes", strtotime($dateTimeRun)));
        // echo $getDateTime.'-'.$startDateTime.'-'.$endDateTime.'<br>';
        if(strtotime($getDateTime)>=$startDateTime && strtotime($getDateTime)<=$endDateTime)
            return $getDateTime;
        else return false;
        
    } 

    // changeItemToNum
    public static function changeItemToNum($arr){
        for($i=0;$i<count($arr);$i++) $arr[$i]=(int)$arr[$i];
        return $arr;
    }

    // getNumberForKeno
     public static function getNumberForKeno($methodSelected,$blockNumber){
        $nubmer=[
            "10"=>[-4,-5,-6,-7,-8],
            "11"=>[-1,-2,-3],
        ];
        //dd($methodSelected,$blockNumber,$nubmer);
        for($i=0;$i<count($blockNumber);$i++)
        if($blockNumber[$i]==1) return  [$nubmer[$methodSelected][$i]];
    }  

    // getDataTicketMega465
    public static function getDataTicketMax3D($orderdetail,$periodIndex,$period,$key,$type){
        // dd($orderdetail,$period);
        $detail=json_decode($orderdetail->details);// dd($detail->product_id);// dd($detail);
        $blocks=config('laravelhtmldomparser.blocks'); 
        $priceBlocks=$detail->priceBlocks;
        $tempData=[];
        foreach($detail->blocksNumber as $no=>$blockNumber)
        if($blockNumber!=null){

            if($key==config('laravelhtmldomparser.categoryType.keno.key') && $detail->methodSelected>9)
                $tempNumber=Vietlott::getNumberForKeno($detail->methodSelected,$blockNumber);
            else $tempNumber=Vietlott::changeItemToNum($blockNumber);

            $tempData[$blocks[$no]]=[
                'number'=>$tempNumber,
                'price'=>(int)$priceBlocks[$no],
                'mpick'=>0,
            ];
        }

        // caculate $statePrint 
        if($key==config('laravelhtmldomparser.categoryType.keno.key')) // keno state remain, print 1 to statePrint
            $statePrint=$period;
        else $statePrint=10+$period-1; // orther, print percific state
        
        $ticket=[
            'data'=>$tempData,
            "type"=>$type,
            "ticketId"=>$orderdetail->id.'#'.$periodIndex,
            "stage"=>$statePrint
        ]; 
        return  $ticket;
    }

    // getDataTicketMega465
    public static function getDataTicketMegaPower($orderdetail,$periodIndex,$period,$key,$type){
        // dd($orderdetail,$period); 
        $detail=json_decode($orderdetail->details);// dd($detail->product_id);// dd($detail);
        $blocks=config('laravelhtmldomparser.blocks');
        $phichoibao=config('laravelhtmldomparser.categoryType.'.$key.'.phichoibao');
        $maChoibao=[0,5,7,8,9,10,11,12,13,14,15,18];
        $tempData=[];
        foreach($detail->blocksNumber as $no=>$blockNumber)
        if($blockNumber!=null){
            $tempData[$blocks[$no]]=[
                'number'=>Vietlott::changeItemToNum($blockNumber),
                'price'=>$phichoibao[$detail->methodSelected],
                'mpick'=>0,
            ];
        }
        
        $ticket=[
            'data'=>$tempData,
            "type"=>$type,
            "ticketId"=>$orderdetail->id.'#'.$periodIndex,
            "stage"=>10+$period-1,
            "coverage"=>$maChoibao[$detail->methodSelected],
        ]; 
        // dd(json_encode($ticket));
        return  $ticket;
    }

    // callAPIPrintTicket ticketsVietlot
    public static function callAPIPrintTicket($ticketsVietlot){

        foreach($ticketsVietlot as $tickets){// orderDetail
            foreach($tickets as $ticket){ // detailPeriod
                // call API printTicket
                Log::debug('callAPIPrintTicket: ',$ticket);
                //Ticket::create(['ticketId'=>$ticket['ticketId']]); 
                $response = Http::withToken(config('laravelveso.tokenApi'))->post(config('laravelveso.postTicketBuyticket'),$ticket);
                if($response->status()==200){
                    //Log::debug($ticket);
                    Log::debug('callAPIPrintTicket API success: '.$ticket['ticketId']);
                    // add ticket to monitor result, if after 1' not result -> refund
                    Ticket::create(['ticketId'=>$ticket['ticketId']]); 
                }else{
                    Log::debug($ticket);
                    Log::debug('callAPIPrintTicket API Fall: '.$ticket['ticketId']);
                    Log::debug($response);
                    // can not call api -> refund this ticket
                    Vietlott::cancelTicketVietlott($ticket['ticketId']);
                }
            } 
        } 
    } 

    // handleGetDataTicketVietlott
    public static function handleGetDataTicketVietlott($orderDetail){
        // check this orderdetail not yet handle
        $tickets=[]; 
        if($orderDetail->status!=config('laravelveso.orderDetailStatus.completed.key')){
            $orderDetail->update(['status'=>config('laravelveso.orderDetailStatus.completed.key')]); 

            $details=json_decode($orderDetail->details); 
            
            if($details->category==config('laravelhtmldomparser.categoryType.keno.key'))
                $buyingPeriods=Vietlott::getBuyingPeriodsNextForKeno(30);
            else{
                // max3dplus get period depend on max3d
                if($details->category==config('laravelhtmldomparser.categoryType.max3dplus.key'))
                    $buyingPeriods=Vietlott::getBuyingPeriodsNext(config('laravelhtmldomparser.categoryType.max3d.key'),6);   
                else 
                    $buyingPeriods=Vietlott::getBuyingPeriodsNext($details->category,6);   
            }
            
            // get periods 
            $specificPeriods=[];
            $orderDetailKey='';
            // for keno get last ticket
            if($details->category==config('laravelhtmldomparser.categoryType.keno.key')){
                $tempPeriodsKeno=[];//get all period from 0->period 
                $period=count($details->buyingPeriods);
                for($i=0;$i<$period;$i++){
                    $tempPeriodsKeno[]=$buyingPeriods[$i];
                    $orderDetailKey.=$details->category.Vietlott::getOnlyPeriod($buyingPeriods[$i]);
                }
                $specificPeriods=$tempPeriodsKeno;   
                $tickets[]=Vietlott::getDataTicketMax3D($orderDetail,$period,$period,config('laravelhtmldomparser.categoryType.keno.key'),config('laravelhtmldomparser.categoryType.keno.keyInServerAPI'));
            }
            else // for orther vietlot
            foreach($details->buyingPeriods as $periodIndex=>$period){ // value of Period
                // value of Period vd: period 5 -> position in $buyingPeriods is: 5-1=4
                // $buyingPeriods is periods i caculate in real time in orders
                // update specific Periods with: period and time
                $specificPeriods[]=$buyingPeriods[$period-1];
                $orderDetailKey.=$details->category.Vietlott::getOnlyPeriod($buyingPeriods[$period-1]); 

                // getDataTicket
                switch ($details->category) {
                    case config('laravelhtmldomparser.categoryType.mega645.key'):   
                        $tickets[]=Vietlott::getDataTicketMegaPower($orderDetail,$periodIndex,$period,config('laravelhtmldomparser.categoryType.mega645.key'),config('laravelhtmldomparser.categoryType.mega645.keyInServerAPI'));
                        break; 
                    case config('laravelhtmldomparser.categoryType.power655.key'):   
                        $tickets[]=Vietlott::getDataTicketMegaPower($orderDetail,$periodIndex,$period,config('laravelhtmldomparser.categoryType.power655.key'),config('laravelhtmldomparser.categoryType.power655.keyInServerAPI'));
                        break; 
                    case config('laravelhtmldomparser.categoryType.max3d.key'):   
                        $tickets[]=Vietlott::getDataTicketMax3D($orderDetail,$periodIndex,$period,config('laravelhtmldomparser.categoryType.max3d.key'),config('laravelhtmldomparser.categoryType.max3d.keyInServerAPI'));
                        break; 
                    case config('laravelhtmldomparser.categoryType.max3dplus.key'):   
                        $tickets[]=Vietlott::getDataTicketMax3D($orderDetail,$periodIndex,$period,config('laravelhtmldomparser.categoryType.max3dplus.key'),config('laravelhtmldomparser.categoryType.max3dplus.keyInServerAPI'));
                        break; 
                    case config('laravelhtmldomparser.categoryType.max3dpro.key'):   
                        $tickets[]=Vietlott::getDataTicketMax3D($orderDetail,$periodIndex,$period,config('laravelhtmldomparser.categoryType.max3dpro.key'),config('laravelhtmldomparser.categoryType.max3dpro.keyInServerAPI'));
                        break;  
                }
            }
            // update specific Periods, detailKey into db
            $details->specificPeriods=$specificPeriods;
            $orderDetail->update(['details'=>json_encode($details),'details_key'=>$orderDetailKey]);
        
        }  
        return $tickets;
    }

    // getNumerPeriodKenoBetweenTwoTime
    public static function getNumerPeriodKenoBetweenTwoTime($start,$end){
        $tempNum=(ceil((strtotime($end)-strtotime($start))/600)) % 48;//round up
        return $tempNum;
    }

    public static function checkInTimeCanPrintVietlott($orderdetailCategory){
        $timeCanPrintVietlott=config('laravelveso.timeCanPrintVietlott');
        $currDateTime = date('Y-m-d H:i:s');
        $currMinuste = date('i',time()) % 10;
        if($orderdetailCategory==config('laravelhtmldomparser.categoryType.keno.key')){
            // 'Keno'=>[['06:15','21:55'],[0,8]] // from: 06:00->21:55 && p:00->08 (p=minust % 10)
            $startTime=date('Y-m-d '.$timeCanPrintVietlott['keno'][0][0]);
            $endTime=date('Y-m-d '.$timeCanPrintVietlott['keno'][0][1]);
            if(strtotime($currDateTime)>strtotime($startTime) && strtotime($currDateTime)<strtotime($endTime) && 
                $currMinuste >$timeCanPrintVietlott['keno'][1][0] && $currMinuste<$timeCanPrintVietlott['keno'][1][1])
            return true;  
            else return false;
        } else{ //for Mega-Power-3D-3DPro
            // 'megaPower3D'=>[['06:00','17:45'],['18:15','21:55']],// from: 06:00->17:45 || 18:15->21:55
            $startTime1=date('Y-m-d '.$timeCanPrintVietlott['megaPower3D'][0][0]);
            $endTime1=date('Y-m-d '.$timeCanPrintVietlott['megaPower3D'][0][1]);
            $startTime2=date('Y-m-d '.$timeCanPrintVietlott['megaPower3D'][1][0]);
            $endTime2=date('Y-m-d '.$timeCanPrintVietlott['megaPower3D'][1][1]);
            if(
                (strtotime($currDateTime)>strtotime($startTime1) && strtotime($currDateTime)<strtotime($endTime1))||
                (strtotime($currDateTime)>strtotime($startTime2) && strtotime($currDateTime)<strtotime($endTime2))
            ) return true;
            else return false;
        }
    }

    public static function getBuyingPeriodsNextForKeno($numberOfKymua){
        $kymuaNext=[];  
        // get latest periods
        $latestPeriod=SettingHelper::getKey(config('laravelhtmldomparser.categoryType.keno.keyLatestResult'));
        $latestPeriod[0]=str_replace('#','',$latestPeriod[0]);
        $lengthPeriod=strlen($latestPeriod[0]);

        // caculate numPeriod
        $currDateTime = date('Y-m-d H:i:s');
        $numPeriod=$latestPeriod[0]+Vietlott::getNumerPeriodKenoBetweenTwoTime($latestPeriod[1],$currDateTime);
        
        $dateTimeRun=$currDateTime;
        $tempdateTimeRun=$currDateTime;
        while(count($kymuaNext)<$numberOfKymua){
            $dateTimeRun=$tempdateTimeRun;
            $getDatetime=Vietlott::findNextPeriodKeno($tempdateTimeRun);
            if($getDatetime){
                $kymuaNext[]='#'.str_pad($numPeriod, $lengthPeriod, '0', STR_PAD_LEFT).' | '.$getDatetime;
                $numPeriod++;
            }   
            $tempdateTimeRun=date('Y-m-d H:i', strtotime("+10 minutes", strtotime($dateTimeRun)));
        }
        return $kymuaNext;
    }

    // updateWinPrizePeriodStatus in orderDetail for vietlott
    public static function updateWinPrizePeriodStatus($orderDetail,$noPeriod,$winPrizeStatus,$moneyNeedAddCustomer,$totalPoint){
       
        $details=json_decode($orderDetail->details);
        if(isset($details->winPrizePeriodStatus))
        $winPrizePeriodStatus=(array)$details->winPrizePeriodStatus;
        else $winPrizePeriodStatus=[];
   
        for($p=0;$p<=$noPeriod;$p++)
        if(!isset($winPrizePeriodStatus[$p])) $winPrizePeriodStatus[$p]=null;

        $winPrizePeriodStatus[$noPeriod]=[$winPrizeStatus,$moneyNeedAddCustomer,$totalPoint];

        $details->winPrizePeriodStatus=$winPrizePeriodStatus;
        $orderDetail->update(['details'=>json_encode($details)]);
    }

    // cancelTicketVietlott when can can not print, receive form: WebhookController | MonitorPrintTicketListener
    // tickedId = orderDetailId +'#'+ periodIndex
    public static function cancelTicketVietlott($ticketId){
        //Log::debug('cancelTicketVietlott: ');
        
        $arr=explode('#',$ticketId);
        $orderDetailId=$arr[0];
        $periodIndex=$arr[1];

        $orderDetail=Orderdetail::find($orderDetailId);
        $details=json_decode($orderDetail->details); 
        $buyingPeriodsStatus=config('laravelveso.buyingPeriodsStatus');
        
        // refund all Period for Keno
        if($orderDetail->category==config('laravelhtmldomparser.categoryType.keno.key')){ 
            if($details->periodStatus[0]!=$buyingPeriodsStatus['canceled'][0]){// check any item period if not yet -> all not yet
                for($periodIndex=0;$periodIndex<count($details->buyingPeriods);$periodIndex++)
                $details->periodStatus[$periodIndex]=$buyingPeriodsStatus['canceled'][0]; // refund all period

                $orderDetail->update(['details'=>json_encode($details)]);  
                $pointRefund=$orderDetail->price;
                Vietlott::refundPointForCustomer($orderDetail,$pointRefund);
            }
        }else{// other Vietlott
            if($details->periodStatus[$periodIndex]!=$buyingPeriodsStatus['canceled'][0]){// if not yet refund -> can refund
                $details->periodStatus[$periodIndex]=$buyingPeriodsStatus['canceled'][0]; // refund this ticket
                $orderDetail->update(['details'=>json_encode($details)]);  
                // refund point for customer 
                $pointRefund=$orderDetail->price/count($details->buyingPeriods);
                Vietlott::refundPointForCustomer($orderDetail,$pointRefund);
            } 
        } 
    }

    //refundTicketRewardForCustomer when admin cancel buy tickets
    public static function refundTicketRewardForCustomer($orderDetail,$vesoProduct,$qtyRefund){
        $order=Order::find($orderDetail->order_id);
        $orderTitle='(HĐ: <a href="'.route('customer.order.show',['order'=>$order]).'">#'. $order->id.'</a>)';
        $customer=$order->user;
        $agencyId=$vesoProduct->user_create_id;
        // getRefundTicketForCustomer
        $tempRefundTicket=Vietlott::getRefundTicketForCustomer($customer,$agencyId);
        $refundTickets=$tempRefundTicket[0];
        $agencyIndex=$tempRefundTicket[1];
        // update tickets reward for customer
        if($vesoProduct->game_type==config('laravelhtmldomparser.categoryType.traditionallottery.gameType.vethuong.key'))
            $refundTickets[$agencyIndex][1]+=$qtyRefund; 
        else $refundTickets[$agencyIndex][2]+=1;

        $customer->update(['refund_tickets'=>json_encode($refundTickets)]);
        // send notification
        $log=config('laravelauth.userLogAction.refundTicketReward').': '.$qtyRefund.' vé '.$vesoProduct->game_type.$orderTitle ;
        UserLog::create(['userId'=>$customer->id,'log'=>$log]); 
        Notification::send($customer, new WinPrizeNotifications($customer,$message=['title'=>$log]));

    }

    // get refundticket
    public static function getRefundTicketForCustomer($customer,$agencyId){
        $refundTickets=$customer->refund_tickets;

        if(!$refundTickets) $refundTickets=[];
        else $refundTickets=json_decode($refundTickets);

        $agencyIndex=-1;

        if($refundTickets)
        foreach($refundTickets as $noRefund=>$refundTicket)
        if($refundTicket[0]==$agencyId){$agencyIndex=$noRefund;break;}

        if($agencyIndex==-1){
            if(!$refundTickets) $agencyIndex=0;
            else $agencyIndex=count($refundTickets);
            $refundTickets[$agencyIndex]=[$agencyId,0,0]; 
        }
        return [$refundTickets,$agencyIndex];
    }

    // refundPointForCustomer
    public static function refundPointForCustomer($orderDetail,$pointRefund){
        $order=Order::find($orderDetail->order_id);
        $newPoint=$order->user->point+$pointRefund;  
        $log=config('laravelauth.userLogAction.refundPoint').': '.number_format($pointRefund).'Đ. Số tiền hiện tại trong Ví:  '.number_format($newPoint).'Đ';
        // caculate new total_refund for order
        $currTotalRefund=$order->total_refund;
        $newTotalRefund=$currTotalRefund+$pointRefund;
        $order->update(['total_refund'=>$newTotalRefund]);
        // update newPoint and log for User
        Vietlott::updatePointForCustomer($order->user,$newPoint,$log);
        // Vietlott::updatePointInfoForCustomer($order->user,-$pointRefund,config('laravelveso.pointInfo.pointBuyTicket.key')); 
        Vietlott::updatePointInfoForCustomer($order->user,$pointRefund,config('laravelveso.pointInfo.pointRefund.key')); 
    }  

    // updateWinPrizes
    public static function updateWinPrizes($orderDetail,$details){
        WinPrize::where('order_detail_id',$orderDetail->id)->delete();
        // traditional
        if($orderDetail->category==config('laravelhtmldomparser.categoryType.traditionallottery.key')){
            $fields=[
                'order_detail_id'=>$orderDetail->id,
                'customer_id'=>$orderDetail->order->userId,
                'agency_id'=>$details->agency_id, 
                'ticket_type'=>$orderDetail->category,
                'prize_date'=>Date::dateDMYtoYMD($details->prize_date), 
                'status'=>config('laravelveso.winPrizeStatus.pendding.key'),
                'details'=>'',
            ];
            WinPrize::create($fields);
            TraditionalTicket::updateWinPrizeStatus($orderDetail,config('laravelveso.winPrizeStatus.pendding.key'),null,0);
        }
        else{ // split every period
            $details=(array)$details;
            $periods=$details['buyingPeriods']; 
            $specificPeriods=$details['specificPeriods']; 
            foreach ($periods as $noPeriod=>$period)
            if($period  && isset($details['winPrizes'][$noPeriod])){
                $tempArr=explode("|",$specificPeriods[$noPeriod]);
                //Log::debug($tempArr);
                if((isset($tempArr) && isset($tempArr[1])))
                $datePrize=Date::dateDMYtoYMD(trim(substr($tempArr[1],0,11))); 
                else $datePrize=date('Y-m-d'); 

                $fields=[
                    'order_detail_id'=>$orderDetail->id,
                    'customer_id'=>$orderDetail->order->userId,
                    'prize_date'=>$datePrize,
                    'ticket_type'=>$orderDetail->category,
                    'noPeriod'=>$noPeriod, 
                    'status'=>config('laravelveso.winPrizeStatus.pendding.key'),
                    'details'=>'',
                ];
                WinPrize::create($fields);
                Vietlott::updateWinPrizePeriodStatus($orderDetail,$noPeriod,config('laravelveso.winPrizeStatus.pendding.key'),null,0);
            }
        }
         
    }

    // updateWinPrizeForOrder
    public static function updateWinPrizeForOrder($orderDetail, $details,$checkWinPrize=false):void{
        $orderDetail->update(['details'=>json_encode($details)]);
        // send notification for customer & admin
        if($checkWinPrize){
            Vietlott::updateWinPrizes($orderDetail,$details);
            Log::debug('updateWinPrizeForOrder and send notification for customer');
            // update total_prize for Order
            $order=Order::find($orderDetail->order_id);  
            $user=User::find($order->userId); 
            $title='Khách hàng '.$user->username.' thắng giải thưởng trong hóa đơn: <a href="'.route('customer.order.show',['order'=>$order]).'">#'. $order->id.'</a>';
            Vietlott::sendNotificationWinPrize($title,$order,$orderDetail);
        }
        else Log::debug('No result updateWinPrizeForOrder');
    }

    // send notification for customer, admin, agency
    public static function sendNotificationWinPrize($title,$order,$orderDetail,$sendFor=[1,0,0]):void{
        // send notification for customer & admin
        $customer=User::find($order->userId); 
        $message=[
            'title'=>$title, 
            'orderId'=>$order->id, 
            'orderDetailId'=>$orderDetail->id, 
            'customerId'=>$customer->id, 
        ];  
        // send notic for customer
        if($sendFor[0]==1)
        Notification::send($customer, new WinPrizeNotifications($customer,$message)); 
        // send notic for admin
        $admin=User::find(1); 
        if($sendFor[1]==1)
        Notification::send($admin, new WinPrizeNotifications($admin,$message)); 
        // send notic for agency
        if($sendFor[2]==1)
        if($orderDetail->category==config('laravelhtmldomparser.categoryType.traditionallottery.key')){
            $details=json_decode($orderDetail->details);  
            $agency=User::find($details->agency_id); 
            Notification::send($agency, new WinPrizeNotifications($agency,$message)); 
        } 
    }

    // prepareDataShowOrder
    public static function prepareDataShowOrder($order){
        return [
            'blocks'=>config('laravelhtmldomparser.blocks'),
            'methodsToPlay'=> config('laravelhtmldomparser.methodsToPlay'),
            'methodsToPlayKeno'=>config('laravelhtmldomparser.methodsToPlayKeno'),
            'total'=>$order->total ,
            'orderId'=>$order->id ,
            'dateAdded'=>$order->created_at,
            'orderType'=>$order->type,
            'bank_transfer_fee'=> $order->bank_transfer_fee,
            'orderStatusValue'=>$order->status,
            'orderStatus'=>config('laravelveso.orderStatus.'.$order->status.'.label'),
            'customerInfo'=>$order->fullname.' - SĐT: '.$order->phone_number,
            'tempRefundTotal'=>0,
            'updateOrderDetail'=>route('admin.updateOrderDetail'),
            'updateWinPrizeVietlott'=>route('admin.updateWinPrizeVietlott'),
            'updateWinPrize'=>route('agency.updateWinPrize'),
        ];     
    }

    // prepareDataShowWinPrize
    public static function prepareDataShowWinPrize(){
        return [
            'blocks'=>config('laravelhtmldomparser.blocks'),
            'methodsToPlay'=> config('laravelhtmldomparser.methodsToPlay'),
            'methodsToPlayKeno'=>config('laravelhtmldomparser.methodsToPlayKeno'), 
            'tempRefundTotal'=>0,
            'orderStatusValue'=>config('laravelveso.orderStatus.paid.key'),
            'updateOrderDetail'=>route('admin.updateOrderDetail'),
            'updateWinPrizeVietlott'=>route('admin.updateWinPrizeVietlott'),
            'updateWinPrize'=>route('agency.updateWinPrize'),
        ];     
    }

    // prepareDataShowOrder
    public static function prepareDataShowOrderdetail($orderDetail){
        $details=(array)json_decode($orderDetail->details);
        $traditionallottery=config('laravelhtmldomparser.categoryType.traditionallottery.key');
        $vietlottType=config('laravelhtmldomparser.categoryType');
        $item=(Object)[
            'rowId'=>$orderDetail->id,
            'id'=>$orderDetail->id,
            'qty'=>$orderDetail->quantity, 
            'qty_refund'=>$orderDetail->quantity_refund>0?$orderDetail->quantity_refund:0,
            'name'=>$orderDetail->category==$traditionallottery?$details['name']:$vietlottType[$orderDetail->category]['name'],
            'prize_date'=>$orderDetail->category==$traditionallottery?$details['prize_date']:'',
            'price'=>$orderDetail->price,
            'options'=>$details,
            'order_id'=>$orderDetail->order_id,
            'images'=>json_decode($orderDetail->images), 
            'orderDetail'=>$orderDetail,
        ];
         
        return $item;
    } 
     
}

