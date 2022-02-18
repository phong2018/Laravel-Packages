<?php

namespace Phonglg\LaravelEcommerce\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Phonglg\LaravelEcommerce\Models\Category;
use Phonglg\LaravelEcommerce\Models\Order;
class Product extends Model
{
    use HasFactory;
    protected $table = 'ecommerce_products';
    protected $guarded = [];

    public function categories(){
        return $this->belongsToMany(Category:: class, 'ecommerce_category_product','product_id','category_id'); 
    }

    public function orders(){
        return $this->belongsToMany(Order:: class);
    }

    // https://laravel.com/docs/9.x/database-testing#factory-and-model-discovery-conventions
    protected static function newFactory()
    {
        return \Phonglg\LaravelEcommerce\Database\Factories\ProductFactory::new();   
    }
}