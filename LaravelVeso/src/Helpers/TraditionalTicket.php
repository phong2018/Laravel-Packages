<?php

namespace Phonglg\LaravelVeso\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelVeso\Models\Vesoproduct; 
use Illuminate\Support\Str;
use Phonglg\LaravelAuth\Models\UserLog;
use Phonglg\LaravelSetting\Helpers\SettingHelper;
use Illuminate\Support\Facades\Notification;
use Phonglg\LaravelVeso\Notifications\WinPrizeNotifications;

class TraditionalTicket
{ 
    // payAccumulatePoint
    public static function payAccumulatePoint($customer,$presenter,$totalTicketsBuyTraditional,$typeUpdate){
        Log::debug('payAccumulatePoint',[$customer,$presenter,$totalTicketsBuyTraditional,$typeUpdate]);
        // customer
        $pointUpdate=$totalTicketsBuyTraditional*SettingHelper::getKey('accumulated_points_for_customer')*$typeUpdate;
        $newAccumulatePointCustomer=$customer->accumulate_point+$pointUpdate;
        if($typeUpdate>0)$typeLog=config('laravelauth.userLogAction.addAccumulatedPointCustomer');
        else $typeLog=config('laravelauth.userLogAction.cancelAddAccumulatedPointCustomer');
        $log=$typeLog.' '.$totalTicketsBuyTraditional.' vé '.number_format($pointUpdate).'Đ. Số điểm hiện tại trong Ví tích lũy:  '.number_format($newAccumulatePointCustomer).'Đ'; 
        TraditionalTicket::updateAccumulatePoint($customer,$newAccumulatePointCustomer,$log);
        // presenter
        if($presenter){
            $pointUpdate=$totalTicketsBuyTraditional*SettingHelper::getKey('accumulated_points_for_presenter')*$typeUpdate;
            $newAccumulatePointPresenter=$presenter->accumulate_point+$pointUpdate;
            if($typeUpdate>0)$typeLog=config('laravelauth.userLogAction.addAccumulatedPointPresenter');
            else $typeLog=config('laravelauth.userLogAction.cancelAddAccumulatedPointPresenter');
            $log=$typeLog.' '.$totalTicketsBuyTraditional.' vé '.number_format($pointUpdate).'Đ. Số điểm hiện tại trong Ví tích lũy:  '.number_format($newAccumulatePointPresenter).'Đ'; 
            TraditionalTicket::updateAccumulatePoint($presenter,$newAccumulatePointPresenter,$log);
        }
    }

    // updateAccumulatePoint
    public static function updateAccumulatePoint($user,$newAccumulatePoint,$log,$sendNotification=false){ 
        $user->update(['accumulate_point'=>$newAccumulatePoint]);
        UserLog::create(['userId'=>$user->id,'log'=>$log]);  
        if($sendNotification) Notification::send($user, new WinPrizeNotifications($user,$message=['title'=>$log]));  
    }

    // payMoneyForAgency_Presendter after buy Traditional ticket
    public static function payMoneyForAgency_Presendter($customer,$orderDetail,$totalTicketsBuyTraditional,$typeUpdate){
        $detail=json_decode($orderDetail->details);
        $typeTicketName=config('laravelhtmldomparser.categoryType.traditionallottery.gameType.'.$detail->game_type.'.name'); 
        $moneyBuyTraditional=$totalTicketsBuyTraditional*$orderDetail->price;
        
        // tranfer money sale ticket for agency
        $agency=User::find($detail->agency_id); 
        if($agency){ 
            $pointAddForAgency=$moneyBuyTraditional-($moneyBuyTraditional*SettingHelper::getKey('commission_for_thantai39')/100)-($moneyBuyTraditional*SettingHelper::getKey('commission_for_presenter')/100);  
            $pointAddForAgency=$pointAddForAgency*$typeUpdate;
            $newPoint=$agency->point + $pointAddForAgency; 
            if($typeUpdate>0)$typeLog=config('laravelauth.userLogAction.addPointBuyTicketForAgency');
            else $typeLog=config('laravelauth.userLogAction.cancelAddPointBuyTicketForAgency');
            $log=$typeLog.' '.$totalTicketsBuyTraditional.' vé  '.$typeTicketName.' '.number_format($pointAddForAgency).'Đ. Số tiền hiện tại trong Ví:  '.number_format($newPoint).'Đ'; 
            
            Vietlott::updatePointForCustomer($agency,$newPoint,$log); 
            Vietlott::updatePointInfoForCustomer($agency,$pointAddForAgency,config('laravelveso.pointInfo.pointPaidSaleTicketForAgency.key')); 
        }
        // tranfer comission sale ticket for presenter
        $presenter=User::find($customer->presenter_id);  
        Log::debug('presenter: ');Log::debug($presenter);
        if($presenter){
            $pointAddForPresenter=$moneyBuyTraditional*SettingHelper::getKey('commission_for_presenter')/100;  
            $pointAddForPresenter=$pointAddForPresenter*$typeUpdate;
            $newPoint=$presenter->point + $pointAddForPresenter; 
            if($typeUpdate>0)$typeLog=config('laravelauth.userLogAction.addPointBuyTicketForPresenter');
            else $typeLog=config('laravelauth.userLogAction.cancelAddPointBuyTicketForPresenter');

            $log=$typeLog.' '.$totalTicketsBuyTraditional.' vé  '.$typeTicketName.' '.number_format($pointAddForPresenter).'Đ. Số tiền hiện tại trong Ví:  '.number_format($newPoint).'Đ'; 
            Vietlott::updatePointForCustomer($presenter,$newPoint,$log); 
            Vietlott::updatePointInfoForCustomer($presenter,$pointAddForPresenter,config('laravelveso.pointInfo.pointCommissionForPresenter.key')); 
         
        } 
        // AccumulatePoint
        TraditionalTicket::payAccumulatePoint($customer,$presenter,$totalTicketsBuyTraditional,$typeUpdate);
    }

    // updateWinPrizeStatus in OrderDetail traditional
    public static function updateWinPrizeStatus($orderDetail,$winPrizeStatus,$moneyNeedAddCustomer,$totalPoint){
        $details=json_decode($orderDetail->details); 
        $details->winPrizeStatus=[$winPrizeStatus,$moneyNeedAddCustomer,$totalPoint];
        $orderDetail->update(['details'=>json_encode($details)]);
    }
    // getTicketType
    public static function getGameTypes(){

        $gameTypes=[];
        $tempGameType=config('laravelhtmldomparser.categoryType.traditionallottery.gameType');

        $gameTypes[]=  (object) $tempGameType['vethuong'];
        $gameTypes[]=  (object) $tempGameType['capnguyen'];
        
        return $gameTypes;
    }

    // getKeyTicket
    public static function getKeyTicket($number,$prize_date,$province,$userCreateId){
        return  substr($number,4,2).'|'.$number.'|'.$prize_date.'|'.Str::slug($province).'|'.str_pad($userCreateId, 9,'0',STR_PAD_LEFT);
    }

    // getCartRefundTicket for traditional
    public static function getCartRefundTicket(){

        if(Auth::check()) $refundTickets=json_decode(Auth::user()->refund_tickets);
        else $refundTickets=[];

        $totalRefund=0;$qtyVethuongRefund=0;$qtyCapnguyenRefund=0;
        // handle refund ticket
        $cart= Cart::content();  
        if($refundTickets)
        foreach($cart as $rowId=>$row)
        if(isset($row->options['product_id'])){ 
            $options=$row->options; 
            $product=Vesoproduct::find($options['product_id']);
            $agency=User::find($product->user_create_id);
            
            $agencyIndex=-1;
            foreach($refundTickets as $noRefun=>$refundTicket)
            if($refundTicket[0]==$agency->id){$agencyIndex=$noRefun;break;}
          
            if($agencyIndex>-1){ 
                if($options['game_type']==config('laravelhtmldomparser.categoryType.traditionallottery.gameType.vethuong.key')){
                    $qtyRefund=$row->qty<$refundTickets[$agencyIndex][1]?$row->qty:$refundTickets[$agencyIndex][1];
                    $qtyVethuongRefund+=$qtyRefund;
                    $refundTickets[$agencyIndex][1]-=$qtyRefund;
                }else{ // capnguyen
                    $qtyRefund=$row->qty<$refundTickets[$agencyIndex][2]?$row->qty:$refundTickets[$agencyIndex][2];
                    $qtyCapnguyenRefund+=$qtyRefund;
                    $refundTickets[$agencyIndex][2]-=$qtyRefund;
                }
                $totalRefund+=$qtyRefund*$product->price;
                $options['qtyRefund']=$qtyRefund;
                Cart::update($rowId, ['options'  => $options]);
            }
        }
        return [$totalRefund,$qtyVethuongRefund,$qtyCapnguyenRefund,$refundTickets];
        
    }
 

    public static function getCurrentTicketsCanBuy($numFilter=""){

        $curHour=date('H',time());
        $curDate=date('Y-m-d'); 
        $nexDate=date('Y-m-d',strtotime("+1 day", strtotime(date('Y-m-d'))));  

        

        $productsCanSale=Vesoproduct::where('status',1)
        ->where('number','like','%'.$numFilter.'%')
        ->where(function($q) use ($curHour,$curDate,$nexDate){
            $q->where('prize_date','>=', $nexDate); // buy > today
            if($curHour<16) // after 16h not buy tickets this date
            $q->orWhere( function($q1) use ($curDate) {   
                $q1->where('prize_date','=',$curDate);
            });
        })->where('quantity','>',0)->orderBy('key','ASC')->get();

        $productsCanNotSale=Vesoproduct::where('status',1)
        ->where('number','like','%'.$numFilter.'%')
        ->where(function($q) use ($curHour,$curDate,$nexDate){
            $q->where('prize_date','>=', $nexDate); // buy > today
            if($curHour<16) // after 16h not buy tickets this date
            $q->orWhere( function($q1) use ($curDate) {   
                $q1->where('prize_date','=',$curDate);
            });
        })->where('quantity',0)->orderBy('key','ASC')->get(); 
       

        $products=$productsCanSale->merge($productsCanNotSale);  
  

        return $products;
    }

    // get name Agency
    public static function getNameAgency($agency){
        $agencyInfo=json_decode($agency->agency_info);
        if(isset($agencyInfo->agencyName)) return $agencyInfo->agencyName;
        else return $agency->name;
    }
    

    // getCurrentTicketsCanSale of curr Agency
    public static function getCurrentTicketsCanSale($numFilter="",$dateFilter=""):object{
        $curHour=date('H',time());
        if($dateFilter!="") $curDate=$dateFilter;
        else $curDate=date('Y-m-d'); 

        // Log::debug('getCurrentTicketsCanSale',[$curDate,$numFilter]);

        $products=Vesoproduct::where('user_create_id',Auth::id())
        ->where('status',1)
        ->where('quantity','>',0)
        ->where('number','like','%'.$numFilter.'%')
        ->where(function($q) use ($curHour,$curDate){
            $q->where('prize_date','>', $curDate); // buy > today
            if($curHour<=16)
            $q->orWhere( function($q1) use ($curDate) {   
                $q1->where('prize_date','=',$curDate);
            });
        })
        ->orderBy('id','DESC')
        ->get();
        
        return $products;
    }
}