<?php
namespace Phonglg\LaravelLayout\Services;

use App\Models\User;
use Phonglg\LaravelVeso\Models\Order;
use Phonglg\LaravelVeso\Models\Vesoproduct;
use Phonglg\LaravelVeso\Services\OrderServices;

class DashboardServices{

    public function getTotalPoint():array
    { 
        // sum customer & agency
        //$users=User::where('role_id','>=',config('laraveluserrole.defaultRoleId'))->get();
        $users=User::all();
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
        foreach($users as $user){
            $pointInfo=json_decode($user->point_info);
            if(isset($pointInfo->pointAdd))$data['pointAdd']+=$pointInfo->pointAdd;
            if(isset($pointInfo->pointWithdraw))$data['pointWithdraw']+=$pointInfo->pointWithdraw;
            if(isset($pointInfo->pointBuyTicket))$data['pointBuyTicket']+=$pointInfo->pointBuyTicket;
            if(isset($pointInfo->pointRefund))$data['pointRefund']+=$pointInfo->pointRefund;
            if(isset($pointInfo->pointWinPrize))$data['pointWinPrize']+=$pointInfo->pointWinPrize;
            if(isset($pointInfo->pointPaidSaleTicketForAgency))$data['pointPaidSaleTicketForAgency']+=$pointInfo->pointPaidSaleTicketForAgency;  
            if(isset($pointInfo->pointCommissionForPresenter))$data['pointCommissionForPresenter']+=$pointInfo->pointCommissionForPresenter;
            if(isset($pointInfo->pointPaidPrize))$data['pointPaidPrize']+=$pointInfo->pointPaidPrize;
        }

        //return [User::where('role_id','>=',config('laraveluserrole.defaultRoleId'))->sum('point'),$data];
        return [User::sum('point'),$data];
    }

    public function getTotalCustomer():int
    { 

        return User::where('role_id',config('laraveluserrole.defaultRoleId'))->count();
    }

    public function getTotalAgency():int
    { 
        return User::where('role_id',config('laraveluserrole.defaultAgencyRoleId'))->count();
    }

    public function getTotalTraditionalTicketToday():int
    { 
        $data['dateStatistics']=[
            'fromDate'=> date('Y-m-d'),
            'toDate'=> date('Y-m-d 23:59:59'),
        ];
        
        return  Vesoproduct::where('prize_date','>=',$data['dateStatistics']['fromDate'])
                            ->where('prize_date','<=',$data['dateStatistics']['toDate'])
                            ->count();
    } 

    public function getOrdersTodayByType($orderType, $orderService):array
    {   

        $data['invoiceStatistics']=[
            'fromDate'=> date('Y-m-d'),
            'toDate'=> date('Y-m-d 23:59:59'),
        ];

        $data['orderType']=$orderType;
        
        $orders=$orderService->filter($data);  
        
        $tempStatisticsOrders=$orderService->statisticsOrdersData($orders);  

        return [$tempStatisticsOrders[0], $orders, $tempStatisticsOrders[1], $tempStatisticsOrders[2]];
    } 
}

?>