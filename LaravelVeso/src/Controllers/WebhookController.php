<?php

namespace Phonglg\LaravelVeso\Controllers;
use Illuminate\Routing\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelVeso\Events\PrintTicketSuccess;
use Phonglg\LaravelVeso\Helpers\Vietlott;

class WebhookController extends Controller 
{ 
    // buyTraditionalLottery
    public function receivedWebhook(Request $request){
        Log::debug('WebhookController receive event autoPrintTicket '.$_SERVER['REMOTE_ADDR']);
        Log::debug($request);

        if($_SERVER['REMOTE_ADDR']==config('laravelveso.ipServerAutoPrintTicket') && $request['statusCode']==200){ 
            $data=json_decode($request['data']); 
            // Log::debug($data->status);
            $payload=json_decode($data->payload);
            // Log::debug($payload->ticketId);
            $typeVietlottInServerAPI=$payload->type;
            $ticketId=$payload->ticketId.'#'.$typeVietlottInServerAPI;
            // Log::debug('Event PrintTicketSuccess: '.$ticketId); 
            if($data->status==200){
                event(new PrintTicketSuccess($ticketId));
            }else{ // print ticket fail 
                Vietlott::cancelTicketVietlott($ticketId);
            }
        }
        return ['success'];
    }  
} 