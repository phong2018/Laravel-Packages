<?php
namespace Phonglg\LaravelTodoList\Database\Seeders; 
 
use Phonglg\LaravelTodoList\Models\TodoList; 
use Illuminate\Database\Seeder;   

class LaravelTodoListSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $this->seedTodoLists(); 
    }

    protected function seedTodoLists() 
    {
        TodoList::factory()->count(5)->create();
    }
    
}