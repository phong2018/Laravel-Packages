<?php

namespace Phonglg\LaravelTodoList\Models;

use App\Models\User; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class TodoList extends Model
{
    use HasFactory;

    protected $table = 'plg_todo_lists';
    // protected $fillable = ['name']; 
    protected $guarded = []; // all fields can assigned

    // https://laravel.com/docs/9.x/database-testing#factory-and-model-discovery-conventions
    protected static function newFactory()
    {
        //return TodoListFactory::new();   
        return \Phonglg\LaravelTodoList\Database\Factories\TodoListFactory::new();   
    }
}