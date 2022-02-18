<?php

namespace Phonglg\LaravelVnPay\Helpers;

use Illuminate\Support\Facades\File;
use Phonglg\LaravelLayout\Helpers\Date;
use Illuminate\Support\Carbon;

class Banks
{
    // getKymuaNextBy: $numberOfKymua,$weekdaysCanBuy,$timeNotAllowBuy
    public static function caculateBankFee($subTotal,$bankCode){
        $banksFee=config('laravelvnpay.banksFee');
        $bankTransferFee=$banksFee[$bankCode][0]*$subTotal/100+$banksFee[$bankCode][1];
        return $bankTransferFee;
    } 
}