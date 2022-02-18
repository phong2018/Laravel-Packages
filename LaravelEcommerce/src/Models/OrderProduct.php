<?php

namespace Phonglg\LaravelEcommerce\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Phonglg\LaravelEcommerce\Models\Product;

class OrderProduct extends Model
{
    use HasFactory;
    protected $table = 'ecommerce_order_product';
    protected $guarded = [];
    public $timestamps = true;

}