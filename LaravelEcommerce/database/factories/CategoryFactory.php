<?php 
namespace Phonglg\LaravelEcommerce\Database\Factories; 

use Phonglg\LaravelEcommerce\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; 

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $name=$this->faker->jobTitle();
        return [
            'name' =>  $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentences(2, true),
        ];
    }
}