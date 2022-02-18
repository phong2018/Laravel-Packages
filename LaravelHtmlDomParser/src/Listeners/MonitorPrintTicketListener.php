<?php

namespace Phonglg\LaravelHtmlDomParser\Listeners;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;   
use Illuminate\Support\Str;
use Phonglg\LaravelHtmlDomParser\Events\MonitorPrintTicketEvent;
use Phonglg\LaravelVeso\Helpers\Vietlott; 
use Phonglg\LaravelVeso\Models\Ticket;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

// handle refund ticket after 90 second not yet received from server print ticket
class MonitorPrintTicketListener
{      
    
    public function handle(MonitorPrintTicketEvent $event)
    {   
        Log::debug('Event MonitorPrintTicketEvent: ');
        Log::debug('Listener MonitorPrintTicketEvent: ');  

        // get $tickets to MonitorPrintTicketEvent

        DB::beginTransaction();
            //$tickets=Ticket::all(); //have to lock
            $tickets=Ticket::lockForUpdate()->get();
            Log::debug('$tickets: ',[$tickets]);
            foreach($tickets as $ticketPeriod)
            if(time()-strtotime($ticketPeriod->created_at)>900){ //900s //15' will delete tickets bc no received print success
                Log::debug('MonitorPrintTicketEvent:: overtime >120s ');Log::debug($ticketPeriod);
                Vietlott::cancelTicketVietlott($ticketPeriod->ticketId);
                // delete to not handle angain
                $ticketPeriod->delete();
            }
        DB::commit();  

        // get jobs need to be excute
        Artisan::call('queue:retry all', []);  // to tranfer froms jobs to  failed_jobs
        Artisan::call('queue:work --tries=5 --stop-when-empty', []); // to run job 
    }
}

