<?php

namespace Phonglg\LaravelVeso\Rules; 

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Phonglg\LaravelVnPay\Helpers\Banks;

class ValidBank implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    public $params, $message;

    public function __construct($params)
    {
        //
        $this->params=$params;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value) //bank_code
    { 
        if($this->params['cartTotal']>0){
            if($value==null){
                $this->message='Chưa chọn ngân hàng thanh toán';
                return false;
            }
            
            $user=Auth::user();
            // caculate totalPrice for Order
            $bankTransferFee=Banks::caculateBankFee($this->params['cartTotal'],$value);  //$value is bank_code
            $totalPrice=$this->params['cartTotal']+$bankTransferFee;
            // bankCodeId=THANTAI39 && Not enought money => return false 
            if($value==config('laravelvnpay.banks.THANTAI39.id') && $totalPrice>$user->point){ //banks.0: THANTAI39
                $this->message='You have just '. number_format($user->point) .'Đ, not enough point to pay for this order.';
                return false;
            } 
        }
        
 
        return true;
        
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
