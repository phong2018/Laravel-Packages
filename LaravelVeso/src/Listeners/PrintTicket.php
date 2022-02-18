<?php

namespace Phonglg\LaravelVeso\Listeners;

use Illuminate\Support\Facades\Log; 
use Phonglg\LaravelVeso\Events\PaidOrderSuccess;
use Phonglg\LaravelVeso\Helpers\Vietlott;
use Phonglg\LaravelVeso\Models\Order; 
use Phonglg\LaravelVeso\Models\Vesoproduct;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Phonglg\LaravelVeso\Helpers\LockPoint;
use Phonglg\LaravelVeso\Helpers\TraditionalTicket;
use Phonglg\LaravelVeso\Jobs\PointJob;
use Phonglg\LaravelVeso\Services\OrderServices;

class PrintTicket
{ 

    // handleQuantityRefund
    public function handleQuantityRefund($quantityReward,$vesoProduct){ 
        $vesoProduct->update(['quantity_reward'=>$quantityReward]); 
    }

    // handleGetTraditionallottery
    public function handleGetTraditionallottery($orderDetail){// dd($orderDetail->details);
        $tempTotalTicketsBuyTraditional=0;
        // check this orderdetail not yet handle
        if($orderDetail->status==config('laravelveso.orderDetailStatus.pendding.key')){ 
            // update status for Orderdetail
            $orderDetail->update(['status'=>config('laravelveso.orderDetailStatus.completed.key')]);
            // get detail and handle
            $detail=json_decode($orderDetail->details);// dd($detail->product_id);
            $vesoProduct=Vesoproduct::find($detail->product_id);// dd($vesoProduct); 
            // update detailKey 
            $orderDetailKey=Vietlott::getKeyForOrderDetail($detail);
            $orderDetail->update(['details_key'=>$orderDetailKey]);
           
            // not enought quantity => refund money for customer => only buy $vesoProduct->quantity tickets
            // this's not need handle bC before store order had valid quatity -> alway enought quantiy
            if($vesoProduct->quantity < $orderDetail->quantity){ 
                $quantity_refund=$orderDetail->quantity-$vesoProduct->quantity;
                $quantity_sold=$vesoProduct->quantity_sold+$vesoProduct->quantity; 
                $tempTotalTicketsBuyTraditional=$vesoProduct->quantity; 
                $orderDetail->update(['quantity_refund'=>$quantity_refund]);
                $vesoProduct->update(['quantity'=>0,'quantity_sold'=>$quantity_sold]);
                //check qtyReward 
                if(isset($detail->qtyRefund) && $detail->qtyRefund>0){
                    $tempQtyReward=($quantity_sold>$detail->qtyRefund)?$detail->qtyRefund:$quantity_sold;
                    $quantity_reward=$vesoProduct->quantity_reward + $tempQtyReward;
                    $this->handleQuantityRefund($quantity_reward,$vesoProduct);
                    $tempTotalTicketsBuyTraditional-=$tempQtyReward;// subtrack qtyTicketReward 
                }
                // have to refund money for customer with $quantity_refund
                $pointRefund=$orderDetail->price * $quantity_refund;
                Vietlott::refundPointForCustomer($orderDetail,$pointRefund); 

            }else{ // enought quantity
                $quantity_remain=$vesoProduct->quantity-$orderDetail->quantity;
                $quantity_sold=$vesoProduct->quantity_sold+$orderDetail->quantity;
                $tempTotalTicketsBuyTraditional=$orderDetail->quantity;
                $orderDetail->update(['quantity_refund'=>0]);
                $vesoProduct->update(['quantity'=>$quantity_remain,'quantity_sold'=>$quantity_sold]);
                //check qtyRefund
                if(isset($detail->qtyRefund) && $detail->qtyRefund>0){
                    $quantity_reward=$vesoProduct->quantity_reward + $detail->qtyRefund;
                    $this->handleQuantityRefund($quantity_reward,$vesoProduct);
                    $tempTotalTicketsBuyTraditional-=$detail->qtyRefund;// subtrack qtyTicketRefund bc reward
                }
            }   
            // update quantity_paid for this product of agency
            $newQtyPaid=$vesoProduct->quantity_paid+$tempTotalTicketsBuyTraditional;
            $vesoProduct->update(['quantity_paid'=>$newQtyPaid]);
        }
        return $tempTotalTicketsBuyTraditional;
    } 

    // payByVnPaySuccess has 2 case: 1: ByVnpay; 2: ByPoint
    public function handle(PaidOrderSuccess $event)
    {
        Log::debug('Event PaidOrderSuccess: '.$event->message);
        Log::debug('Listener PrintTicket: '.$event->message); 

        $order=Order::find($event->message); // find by OrderId 

        // needCheckLockPoint
        if($event->needCheckLockPoint){
            $needCheckLockPoint=true;
            $usersLockPoint=(new OrderServices())->getUsersLockPoint($order->id);
        }else{// dont need checkLockPoint bc call from queue job and had check before
            $needCheckLockPoint=false;
            $usersLockPoint=[0,(new OrderServices())->getUsersNeedCheckLockPoint($order->id)];
        } 

        // handle if needCheck and had UserPointLock -> add to queue
        if($needCheckLockPoint && $usersLockPoint[0]){// add to queue 
            Log::debug('PaidOrderSuccess PointJob dispatch');
            $message=['typeJob'=>config('laravelveso.pointJobType.PaidOrderSuccess.key'),'orderId'=>$event->message];
            PointJob::dispatch($message);
            
        }else{// no user lock point 
            $order->update(['status'=>config('laravelveso.orderStatus.paid.key')]);// success/failure 
            // handle for buyLottery => printicket
            if($order->type==config('laravelveso.orderTypes.buyLottery.key')){
                // update refund_tickets for Customer after PaidOrderSuccess
                $customer=$order->user;
                if(isset($customer->temp_data)){
                    $refundTickets=$customer->temp_data;
                    $customer->update(['refund_tickets'=>$refundTickets,'temp_data'=>null]); 
                } 
                // get tickets to call api print
                $ticketsVietlot=[]; 
                foreach($order->Orderdetails as $orderDetail){

                    // orderdetail is traditional lottery 
                    if($orderDetail->category==config('laravelhtmldomparser.categoryType.traditionallottery.key')){
                        $totalTicketsBuyTraditional=$this->handleGetTraditionallottery($orderDetail);
                        // pay Money BuyTicket for Agency & pay Commisstion for presenter
                        if($totalTicketsBuyTraditional>0){ 
                            // commission
                            TraditionalTicket::payMoneyForAgency_Presendter($customer,$orderDetail,$totalTicketsBuyTraditional,1);
                        } 
                    }
                    else{  // orderdetail is vietlott
                        if(Vietlott::checkInTimeCanPrintVietlott($orderDetail->category)){
                            $ticketsVietlot[]=Vietlott::handleGetDataTicketVietlott($orderDetail);
                        }  
                        else{ // update waitingForCallPrint to call later in schedule MonitorOrderDetailWatingListener
                            $orderDetail->update(['status'=>config('laravelveso.orderDetailStatus.waitingForCallPrint.key')]);
                        }
                    }
                }
                // callAPIPrintTicket
                Vietlott::callAPIPrintTicket($ticketsVietlot);
                
            }else{ // handle buyPoint for customer => add point for customer
                $pointAdd=$order->total-$order->bank_transfer_fee;
                $newPoint=$order->user->point+$pointAdd; 
                $log=config('laravelauth.userLogAction.addPointsSuccess').': '.number_format($pointAdd).'Đ. Số tiền hiện tại trong Ví:  '.number_format($newPoint).'Đ';
                Vietlott::updatePointForCustomer($order->user,$newPoint,$log); 
                Vietlott::updatePointInfoForCustomer($order->user,$pointAdd,config('laravelveso.pointInfo.pointAdd.key')); 
            }

            LockPoint::unLockPointUsers($usersLockPoint[1]);
        }
    }
}