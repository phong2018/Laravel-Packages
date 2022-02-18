<?php

namespace Phonglg\LaravelTest\Tests\Feature\LaravelPost;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Phonglg\LaravelTodoList\Models\TodoList;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    private $todoList;

    // 
    public function setUp():void{
        
        parent::setUp();

        // plg exactly the full reason why it is failing
        $this->withoutExceptionHandling();

        TodoList::whereNotNull('id')->delete();
        $this->todoList=TodoList::factory()->create();

    }
    
    // sail php artisan test --filter test_todo_list_index
    public function test_todo_list_index()
    { 
        //1. preparation / prepare

        //2. action /perform
        $response= $this->getJson(route('todoList.index'));

        // dd($response->json());

        //3. asertion / predict
        $this->assertEquals(1,count($response->json()));

    } 

    // sail php artisan test --filter test_todo_list_show
    public function test_todo_list_show()
    {  

        $respone=$this->getJson(route('todoList.show',$this->todoList->id))
        ->assertOk()
        ->json();
        //assertOk require return status: 200
 
        $this->assertEquals($respone['name'],$this->todoList->name);

    }

    // sail php artisan test --filter test_todo_list_store
    public function test_todo_list_store()
    { 
        $todoList=TodoList::factory()->make();

        $response =$this->postJson(route('todoList.store',['name'=>$todoList->name]))
        ->assertCreated()
        ->json();

        //assertCreated require return status: 201
        $this->assertEquals($todoList->name,$response['name']);

        $this->assertDatabaseHas('plg_todo_lists',['name'=>$todoList->name]);
    }

    // sail php artisan test --filter test_todo_list_store_valid_name_field_required_when_store
    public function test_todo_list_store_valid_name_field_required_when_store()
    {
        $todoList=TodoList::factory()->make();
        $this->withExceptionHandling();

        $respone=$this->postJson(route('todoList.store',['name'=>'']))
        ->assertUnprocessable() //422
        ->assertJsonValidationErrors(['name']) //valid name field
        ->json();

        //dump($respone);
        //$respone->assertCreated();
        //$respone->assertNotFound();
    }

    // sail php artisan test --filter test_todo_list_delete
    public function test_todo_list_delete()
    {
        $this->deleteJson(route('todoList.destroy',$this->todoList->id))
        ->assertNoContent();

        $this->assertDatabaseMissing('plg_todo_lists',['name'=>$this->todoList->name]) ;

    }

    // sail php artisan test --filter test_todo_list_update
    public function test_todo_list_update()
    {
        $todoList=TodoList::factory()->make();

        $this->patchJson(route('todoList.update',$this->todoList->id),['name'=>$todoList->name])->assertOk();

        $this->assertDatabaseHas('plg_todo_lists',['id'=>$this->todoList->id,'name'=>$todoList->name]);
    }

    // sail php artisan test --filter test_todo_list_store_valid_name_field_required_when_update
    public function test_todo_list_store_valid_name_field_required_when_update()
    { 
        $this->withExceptionHandling();

        $respone=$this->patchJson(route('todoList.update',$this->todoList->id))
        ->assertUnprocessable() //422
        ->assertJsonValidationErrors(['name']) //valid name field
        ->json(); 
    }
    
}
