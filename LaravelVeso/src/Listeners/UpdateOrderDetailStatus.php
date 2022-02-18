<?php

namespace Phonglg\LaravelVeso\Listeners;

use Illuminate\Support\Facades\Log;   
use Phonglg\LaravelVeso\Events\PrintTicketSuccess;
use Phonglg\LaravelVeso\Helpers\Vietlott;
use Phonglg\LaravelVeso\Models\Order;
use Phonglg\LaravelVeso\Models\Orderdetail;
use Phonglg\LaravelVeso\Models\Ticket;
use Phonglg\LaravelVeso\Models\Vesoproduct;

class UpdateOrderDetailStatus
{ 

    public function handle(PrintTicketSuccess $event)
    { 
        Log::debug('Event PrintTicketSuccess: '.$event->message);
        Log::debug('Listener UpdateOrderDetailStatus: '.$event->message);  

        // handle update status for orderDeail has this ticket_period 
        $arr=explode('#',$event->message);
    
        $orderDetailId=$arr[0];
        $periodIndex=$arr[1];
        // use to check Keno type;// get follow config of server API call printticket: keyInServerAPI
        $typeVietlottInServerAPI=$arr[2];

        // delete Ticket in Queue because has received respone from Hook of Server Api auto Print 
        $ticket=Ticket::where('ticketId',$orderDetailId.'#'.$periodIndex)->first();

        // check if ticket remain exist or deleted
        if($ticket==null){ 
            Log::debug('PrintTicketSuccess but delete ticket, because >120s or refund:'.$ticket);
        }else{
            Log::debug('PrintTicketSuccess and recode result');
            $ticket->delete();
            $orderDetail=Orderdetail::find($orderDetailId);
            $details=json_decode($orderDetail->details); 
                
            $buyingPeriodsStatus=config('laravelveso.buyingPeriodsStatus');

            // if pedding -> handle else do nothing
            if($typeVietlottInServerAPI==config('laravelhtmldomparser.categoryType.keno.keyInServerAPI')){ //keno
                for($i=0;$i<$periodIndex;$i++)
                    $details->periodStatus[$i]=$buyingPeriodsStatus['success'][0];
                $orderDetail->update(['details'=>json_encode($details)]); 
            }else{// orther vietlott
                if($details->periodStatus[$periodIndex]==$buyingPeriodsStatus['pendding'][0])
                $details->periodStatus[$periodIndex]=$buyingPeriodsStatus['success'][0];
                else Log::debug('PrintTicketSuccess has handled: '.$event->message.'. with status: '.$details->periodStatus[$periodIndex]);
                $orderDetail->update(['details'=>json_encode($details)]); 
            } 
        } 
        
        // dd($details);
        Log::debug('Finished for buy one ticket in Order Detail with Specific period');  
    }
}