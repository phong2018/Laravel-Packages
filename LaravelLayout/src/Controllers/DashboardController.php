<?php

namespace Phonglg\LaravelLayout\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelLayout\Services\DashboardServices;
use Phonglg\LaravelVeso\Services\OrderServices;

class DashboardController extends Controller
{
    //
    public function index(DashboardServices $services , OrderServices $orderService)
    { 

        $data=[]; 

        $tempTotalPoint=$services->getTotalPoint();
        $data['totalPoint']=$tempTotalPoint[0];
        $data['totalPointDetail']=$tempTotalPoint[1];
        // dd($tempTotalPoint);
        

        $data['totalCustomer']=$services->getTotalCustomer();
        $data['totalAgency']=$services->getTotalAgency();
        $data['totalTraditionalTicketToday']=$services->getTotalTraditionalTicketToday();

        

        $tempOrder=$services->getOrdersTodayByType(config('laravelveso.orderTypes.buyLottery.key'),$orderService); 
        $data['totalSalesBuyTicketToday']=$tempOrder[0];
        $data['recentOrdersBuyTicket']=$tempOrder[1];

        $tempOrder=$services->getOrdersTodayByType(config('laravelveso.orderTypes.buyPoint.key'),$orderService); 
        $data['totalSalesBuyPointToday']=$tempOrder[0];
        $data['recentOrdersBuyPoint']=$tempOrder[1];  
        
        $tempStatisticsOrders=$orderService->statisticsOrdersData( $data['recentOrdersBuyTicket']); ;
        $data['totalSaleOrder']=$tempStatisticsOrders[0]; 
        $data['countOrderRefund']=$tempStatisticsOrders[1];
        $data['totalOrderRefund']=$tempStatisticsOrders[2];  

        // dd($data);

        

        return view('laravellayout::dashboard',['data'=>$data]);
    }
     
}