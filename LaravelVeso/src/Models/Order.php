<?php

namespace Phonglg\LaravelVeso\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Phonglg\LaravelVeso\Models\Orderdetail;

class Order extends Model
{
    use HasFactory;
    protected $table = 'veso_orders';
    protected $guarded = [];
    
    public function Orderdetails(){
        return $this->hasMany(Orderdetail::class);
    }

    public function user(){  
        return $this->belongsTo(User::class, 'userId');
    }

  
  
}