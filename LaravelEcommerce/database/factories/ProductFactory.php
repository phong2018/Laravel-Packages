<?php 
namespace Phonglg\LaravelEcommerce\Database\Factories; 

use Phonglg\LaravelEcommerce\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str; 

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $productSuffixes=['Sweater','Pants','Shirt','Classes','Hat','Trouser'];
        
        $name=$this->faker->company().' '. Arr::random($productSuffixes);

        return [
            'name' =>  $name,
            'slug' => Str::slug($name),
            'image'=>'',
            'description' => $this->faker->realText(320),
            'price'=>$this->faker->numberBetween(1000,1000000),
        ];
    }
}