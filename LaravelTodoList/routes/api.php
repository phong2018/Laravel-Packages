   
<?php
 
use Illuminate\Support\Facades\Route;
use Phonglg\LaravelTodoList\Controllers\TodoListController;

 Route::group(['middleware' => ['api']], function () {
 
     //public route
     Route::get('/api/publicTodoList', function () {
         return array('xinchao' => 'Hello World PublicTodoList 1');
     })->name('api.publicTodoList');  

     // Todolist
     Route::prefix('')->group(__DIR__ . '/todoListRoutes.php'); 
     

     //protected Route by auth:sanctum 
     Route::group(['middleware' => ['auth:sanctum']], function () {
         Route::get('/api/protectTodoList', function () {
             return array('xinchao' => 'Hello World ProtectTodoList');
         })->name('api.protectTodoList'); 

     });
 });
 
 
 