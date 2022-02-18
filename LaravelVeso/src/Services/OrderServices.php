<?php
namespace Phonglg\LaravelVeso\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelLayout\Helpers\Date;
use Phonglg\LaravelVeso\Helpers\LockPoint;
use Phonglg\LaravelVeso\Models\Order;

class OrderServices{

    public static function filter($dataFilter)
    {  
        $orders=Order::orderBy('id','DESC')
        ->where('type',$dataFilter['orderType'])
        ->where('created_at','>=',$dataFilter['invoiceStatistics']['fromDate'])
        ->where('created_at','<=',$dataFilter['invoiceStatistics']['toDate'])
        ->get();
        return $orders;
    }

    public static function filterOnlyDate($dataFilter)
    {  
        $orders=Order::orderBy('id','DESC') 
        ->where('created_at','>=',$dataFilter['invoiceStatistics']['fromDate'])
        ->where('created_at','<=',$dataFilter['invoiceStatistics']['toDate']);
        return $orders;
    }

    public function statisticsOrdersData($orders):array{
        $totalSale=0;
        $countOrderRefund=0;
        $totalOrderRefund=0;
        foreach($orders as $order){
            $totalSale+=$order->total-$order->bank_transfer_fee;
            if($order->total_refund>0){
                $countOrderRefund++;
                $totalOrderRefund+=$order->total_refund;
            }
        }
        return [$totalSale,$countOrderRefund,$totalOrderRefund];
    }

    // getUsersLockPointByOrderDetail 
    public function getUsersLockPointByOrderDetail($orderDetail){
        $order= $order=Order::find($orderDetail->order_id); // find by OrderId
        $checkUsersLockPoint=0;
        $usersCheckLock=[];
        // customer
        $usersCheckLock[]=$order->user; 
        // presenter
        $presenter=User::find($order->user->presenter_id);
        if($presenter) $usersCheckLock[]=$presenter; 
        
        // agency     
        if($orderDetail->category==config('laravelhtmldomparser.categoryType.traditionallottery.key')){
            $detail=json_decode($orderDetail->details);
            $agency=User::find($detail->agency_id); 
            $usersCheckLock[]=$agency;  
        }

        $checkLockPoint=LockPoint::checkLockPointUsers($usersCheckLock);

        if($checkLockPoint)$checkUsersLockPoint=1;
        else $checkUsersLockPoint=0;
    
        return [$checkUsersLockPoint,$usersCheckLock];
    }

    // getUsersNeedCheckLockPoint
    public function getUsersNeedCheckLockPoint($orderId){
        $order= $order=Order::find($orderId); // find by OrderId
       
        $usersCheckLock=[];
        // customer
        $usersCheckLock[]=$order->user; 
        // presenter
        $presenter=User::find($order->user->presenter_id);
        if($presenter) $usersCheckLock[]=$presenter; 
        // agency
        if($order->type==config('laravelveso.orderTypes.buyLottery.key'))
        foreach($order->Orderdetails as $orderDetail){
            $detail=json_decode($orderDetail->details);
            if(isset($detail->agency_id)){
                $agency=User::find($detail->agency_id); 
                if($agency) $usersCheckLock[]=$agency;  
            }
        }
        return $usersCheckLock;
    }

    // getusersCheckLock by OrderId
    public function getUsersLockPoint($orderId){ 

        $usersCheckLock=$this->getUsersNeedCheckLockPoint($orderId);
        
        $checkLockPoint=LockPoint::checkLockPointUsers($usersCheckLock);

        if($checkLockPoint)$checkUsersLockPoint=1;
        else $checkUsersLockPoint=0;

        return [$checkUsersLockPoint,$usersCheckLock];
    }

    public function statisticsOrdersPointData($orders):array{ 
        $countOrderAddPoint=0;
        $totalOrderAddPoint=0;
        $countOrderWithdrawPoint=0;
        $totalOrderWithdrawPoint=0;
        foreach($orders as $order){ 
            if($order->type==config('laravelveso.orderTypes.buyPoint.key')){
                $countOrderAddPoint++;
                $totalOrderAddPoint+=$order->total-$order->bank_transfer_fee;
            }
            if($order->type==config('laravelveso.orderTypes.withdrawPoint.key')){
                $countOrderWithdrawPoint++;
                $totalOrderWithdrawPoint+=$order->total-$order->bank_transfer_fee;
            }
        }
        return [$countOrderAddPoint,$totalOrderAddPoint,$countOrderWithdrawPoint,$totalOrderWithdrawPoint];
    }
}

?>