   
<?php
 
 use Illuminate\Support\Facades\Route;
use Phonglg\LaravelTodoList\Controllers\TodoListController;
// sail php artisan route:list --name="todo"

// api
Route::apiResource('todoList', TodoListController::class);


// Route::get('todoList/index', [TodoListController::class, 'index'])->name('todoList.index');
// Route::get('todoList/show/{todoList}', [TodoListController::class, 'show'])->name('todoList.show'); 
// Route::post('todoList/store', [TodoListController::class, 'store'])->name('todoList.store');
// Route::delete('todoList/{todoList}', [TodoListController::class, 'destroy'])->name('todoList.destroy');
// Route::patch('todoList/{todoList}', [TodoListController::class, 'update'])->name('todoList.update');
 
 
 