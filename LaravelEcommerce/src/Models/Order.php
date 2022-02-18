<?php

namespace Phonglg\LaravelEcommerce\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Phonglg\LaravelEcommerce\Models\Product;

class Order extends Model
{
    use HasFactory;
    protected $table = 'ecommerce_orders';
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
}