<?php

namespace Phonglg\LaravelHtmlDomParser\Listeners;
 
use Illuminate\Support\Facades\Log;    
use Phonglg\LaravelHtmlDomParser\Events\MonitorOrderDetailWatingEvent;
use Phonglg\LaravelVeso\Helpers\Vietlott; 
use Phonglg\LaravelVeso\Models\Orderdetail; 

// handle refund ticket after 90 second not yet received from server print ticket
class MonitorOrderDetailWatingListener
{      
    public function handle(MonitorOrderDetailWatingEvent $event)
    {  
        Log::debug('Event MonitorOrderDetailWatingEvent: ');
        Log::debug('Listener MonitorOrderDetailWatingListener: ');  

        // get orderDetails waitingForCallPrint 
        $orderDetails=Orderdetail::where('status',config('laravelveso.orderDetailStatus.waitingForCallPrint.key'))
        ->get();

        $ticketsVietlot=[];
        foreach($orderDetails as $orderdetail){
            if(Vietlott::checkInTimeCanPrintVietlott($orderdetail->category)){
                $ticketsVietlot[]=Vietlott::handleGetDataTicketVietlott($orderdetail);
            }  
        }

        // dd($ticketsVietlot);
        Vietlott::callAPIPrintTicket($ticketsVietlot);   
    }
}

