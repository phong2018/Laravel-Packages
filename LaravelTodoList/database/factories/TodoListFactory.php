<?php 
namespace Phonglg\LaravelTodoList\Database\Factories; 

use Phonglg\LaravelTodoList\Models\TodoList;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; 

class TodoListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TodoList::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $name=$this->faker->jobTitle();
        return [
            'name' =>  $name
        ];
    }
}