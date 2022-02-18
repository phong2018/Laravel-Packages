<?php
namespace Phonglg\LaravelEcommerce\Database\Seeders; 
 
use Phonglg\LaravelEcommerce\Models\Category;
use Phonglg\LaravelEcommerce\Models\Product; 
use Illuminate\Database\Seeder;  
use Illuminate\Database\Eloquent\Collection;

class LaravelEcommerceSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $this->seedCategories();
        $this->seedProducts();
        $this->seedProductCategory();
    }

    protected function seedCategories() 
    {
        Category::factory()->count(5)->create();
    }
    protected function seedProducts() 
    {
        Product::factory()->count(20)->create();
    }

    protected function seedProductCategory() 
    {
        $categories = Category::all();

        Product::all()->each(function($product) use ($categories){
            $product->categories()->attach(
                $categories->random(2)->pluck('id')->toArray()
            );
        });
    }
}