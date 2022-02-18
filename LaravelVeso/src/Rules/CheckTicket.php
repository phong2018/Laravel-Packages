<?php

namespace Phonglg\LaravelVeso\Rules; 

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Validation\Rule;
use Phonglg\LaravelVeso\Models\Vesoproduct;

class CheckTicket implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $message='';
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {  

        if(Cart::count()==0){
            $this->message='Không có vé trong giỏ hàng';
            return false;
        }

        foreach(Cart::content() as $row) {
            $tempOption=$row->options;
            if($tempOption['category']==config('laravelhtmldomparser.categoryType.traditionallottery.key')){
                $ticket=Vesoproduct::find($tempOption['product_id']);
                if($row->qty > $ticket->quantity){
                    $tempOption['message']='* Chỉ còn '.$ticket->quantity.' vé';
                    Cart::update( $row->rowId, ['options' => $tempOption]); // Will update the name
                    $this->message='Không đủ số lượng vé để bán, hãy kiểm tra lại giỏ hàng!';
                    return false;
                }
                else {
                    $tempOption['message']='';
                    Cart::update( $row->rowId, ['options' => $tempOption]); // Will update the name
                }
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
