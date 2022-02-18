<?php
use Illuminate\Support\Facades\Route;    
use Phonglg\LaravelPost\Controllers\PostController;
use Phonglg\LaravelPost\Controllers\ThreadController;

Route::get('/LaravelPost', function () {
    return 'LaravelPost';
}); 

Route::group(['middleware' => ['web']], function () { 
    Route::prefix('')->group(__DIR__ . '/homeRoutes.php'); 
    Route::get('/p/{slug}', [PostController::class, 'showSlug'])->name('post.showSlug');
    Route::get('/t/{slug}', [ThreadController::class, 'showSlug'])->name('thread.showSlug');
});
 
// admin
Route::group(['middleware' => ['web','auth']], function () {  
    Route::prefix('admin')->group(__DIR__ . '/postRoutes.php'); 
    Route::prefix('admin')->group(__DIR__ . '/threadRoutes.php'); 
});
 
