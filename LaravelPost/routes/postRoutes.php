<?php

use Phonglg\LaravelPost\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/post/getData', [PostController::class, 'getData'])->name('post.getData');

Route::get('/post/list', [PostController::class, 'index'])->name('post.index');

Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
Route::post('/post', [PostController::class, 'store'])->name('post.store');

Route::get('/post/{post}', [PostController::class, 'edit'])->name('post.show');

Route::get('/post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');

Route::put('/post/{post}', [PostController::class, 'update'])->name('post.update');

Route::post('/post/{post}/copy', [PostController::class, 'copy'])->name('post.copy');

Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.destroy');