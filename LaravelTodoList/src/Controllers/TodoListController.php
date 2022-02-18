<?php

namespace Phonglg\LaravelTodoList\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Routing\Controller;
use Phonglg\LaravelTodoList\Models\TodoList;
use Symfony\Component\HttpFoundation\Response;

use function Tinify\validate;

class TodoListController extends Controller 
{ 

    
    // index
    public function index(){
        
        $list=TodoList::all();
        // return array('TodoListController.list' => 'Hello TodoListController');

        return response($list);

    }
 

    public function show(TodoList $todoList){ 
        // when u not return status, its default return 200
        return response($todoList);
    }

    public function store(Request $request){ 
        $fields=$request->validate([
            'name'=>'required',
        ]);
        $todoList=TodoList::create($request->all());
        //return response($todoList,201);
        //return response($todoList,Response::HTTP_CREATED);


        return $todoList;
    }

    public function destroy(TodoList $todoList)
    {
        $todoList->delete(); 
        return Response('',Response::HTTP_NO_CONTENT);
    } 

    public function update(Request $request, TodoList $todoList)
    { 
        $fields=$request->validate([
            'name'=>'required',
        ]);

        $todoList->update($fields); 
        return $todoList; 
    
    }

}