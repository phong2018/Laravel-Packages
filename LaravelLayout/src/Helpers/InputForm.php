<?php

namespace Phonglg\LaravelLayout\Helpers;

use Illuminate\Support\Facades\File;

class InputForm
{
    public static function getStatus()
    {
        $items=[];
        $items[]=  (object) [
            'keyValue'=>1,
            'keyName'=>'Enable',
        ];
        $items[]=  (object) [
            'keyValue'=>0,
            'keyName'=>'Disable',
        ];
        
        return $items;
    } 

    
    public static function getStatusUser()
    {
        $items=[];
        $items[]=  (object) [
            'keyValue'=>config('laraveluserrole.userStatus.enable.key'),
            'keyName'=>config('laraveluserrole.userStatus.enable.lablel'),
        ];
        $items[]=  (object) [
            'keyValue'=>config('laraveluserrole.userStatus.disable.key'),
            'keyName'=>config('laraveluserrole.userStatus.disable.lablel'),
        ];
        
        return $items;
    } 

    public static function getPayments()
    {
        $items=[];
        $items[]=  (object) [
            'keyValue'=>config('laravelvnpay.banks.COD.id'),
            'keyName'=>'Trực tiếp',
        ];
        $items[]=  (object) [
            'keyValue'=>'bank',
            'keyName'=>'Online',
        ];
        
        return $items;
    } 

    public static function getOrderTypes()
    {
        $items=[];
        $items[]=  (object) [
            'keyValue'=>config('laravelveso.orderTypes.buyPoint.key'),
            'keyName'=>config('laravelveso.orderTypes.buyPoint.label'),
        ];
        $items[]=  (object) [
            'keyValue'=>config('laravelveso.orderTypes.withdrawPoint.key'),
            'keyName'=>config('laravelveso.orderTypes.withdrawPoint.label'),
        ];
        
        return $items;
    } 

    public static function getTicketTypes()
    {
        $items=[];
        $items[]=  (object) [
            'keyValue'=>config('laravelveso.ticketTypes.traditionallottery.key'),
            'keyName'=>config('laravelveso.ticketTypes.traditionallottery.label'),
        ];
        $items[]=  (object) [
            'keyValue'=>config('laravelveso.ticketTypes.vietlott.key'),
            'keyName'=>config('laravelveso.ticketTypes.vietlott.label'),
        ];
        
        return $items;
    } 

    

    
 
}