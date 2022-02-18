<?php
namespace Phonglg\LaravelVeso\Services;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelLayout\Helpers\Date;

class VesoProductServices{

    public function getReportSaleTicket($vesoProducts)
    {
        $reports=[
            'vethuong'=>[
                'qtyTicket'=>0,
                'qtyTicketSoldOln'=>0,
                'totalTicketSoldOln'=>0,
                'qtyTicketSoldDirect'=>0,
                'totalTicketSoldDirect'=>0,
            ],
            'capnguyen'=>[
                'qtyTicket'=>0,
                'qtyTicketSoldOln'=>0,
                'totalTicketSoldOln'=>0,
                'qtyTicketSoldDirect'=>0,
                'totalTicketSoldDirect'=>0,
            ],
        ];

        
        Log::debug($vesoProducts);
        foreach($vesoProducts as $ticket)
        if($ticket)
        {
            Log::debug($ticket);
            $reports[$ticket->game_type]['qtyTicket']+= $ticket->quantity;
            $reports[$ticket->game_type]['qtyTicketSoldOln']+= $ticket->quantity_sold;
            $reports[$ticket->game_type]['totalTicketSoldOln']+= $ticket->quantity_sold*$ticket->price;
            $reports[$ticket->game_type]['qtyTicketSoldDirect']+= $ticket->quantity_sold_direct; 
            $reports[$ticket->game_type]['totalTicketSoldDirect']+= $ticket->quantity_sold_direct*$ticket->price;
        }

        return $reports;
    } 
}