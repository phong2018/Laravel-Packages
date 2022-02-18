<?php
namespace Phonglg\LaravelEcommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Phonglg\LaravelEcommerce\Models\Product;

class Category extends Model
{
    use HasFactory;
    protected $table = 'ecommerce_categories';
    protected $guarded = [];

    public function products(){
        return $this->belongsToMany(Product:: class, 'ecommerce_category_product','category_id','product_id');  
    }
    
    // https://laravel.com/docs/9.x/database-testing#factory-and-model-discovery-conventions
    protected static function newFactory()
    {
        return \Phonglg\LaravelEcommerce\Database\Factories\CategoryFactory::new();   
    }
 
  
}