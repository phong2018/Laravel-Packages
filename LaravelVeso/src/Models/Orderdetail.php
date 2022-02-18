<?php

namespace Phonglg\LaravelVeso\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Orderdetail extends Model
{
    use HasFactory;
    protected $table = 'veso_orders_details';
    protected $guarded = [];
 
    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
}