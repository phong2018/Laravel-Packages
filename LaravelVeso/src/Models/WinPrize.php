<?php

namespace Phonglg\LaravelVeso\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Phonglg\LaravelVeso\Models\Orderdetail;

class WinPrize extends Model
{
    use HasFactory;
    protected $table = 'veso_win_prizes';
    protected $guarded = [];
    
    public function orderDetail(){
        return $this->belongsTo(Orderdetail::class,'order_detail_id');
    }

    public function customer(){
        return $this->belongsTo(User::class,'customer_id');
    }

    public function agency(){
        return $this->belongsTo(User::class,'agency_id');
    }
  
}