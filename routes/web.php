<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\CommentController;


Route::get('/', [TaskController::class, 'index']);

Route::get('/tasks', [TaskController::class, 'index']);

Route::get('/tasks/task-details/{id}', [TaskController::class, 'show'])->name('task.details');

Route::put('/tasks/task-details/{id}', [CommentController::class, 'store'])->middleware('auth');;

Route::delete('/tasks/task-details/{id}/{image}', [UploadController::class, 'destroy'])->middleware('auth');;

Route::delete('/tasks/task-details/{id}/comments/{comment}', [CommentController::class, 'destroy'])->middleware('auth');;

Route::get('/tasks/create', [TaskController::class, 'create'])->middleware('auth');

Route::get('/tasks/manage', [TaskController::class, 'manage'])->middleware('auth');

Route::post('/tasks', [TaskController::class, 'store'])->middleware('auth');

Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->middleware('auth');

Route::put('/tasks/{task}', [TaskController::class, 'update'])->middleware('auth');

Route::put('/tasks/{task}/updateStatus', [TaskController::class, 'updateStatus'])->middleware('auth');

Route::get('/tasks/{task}/task-child/create', [TaskController::class, 'createChild'])->middleware('auth');;

Route::post('/tasks/child-task/{task}', [TaskController::class, 'storeChild'])->middleware('auth');;

Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->middleware('auth');

Route::get('/register', [UserController::class, 'create'])->middleware('guest');

Route::post('/users', [UserController::class, 'store'])->middleware('guest');

Route::get('/users/manage', [UserController::class, 'manage'])->middleware('auth');

Route::post('/', [UserController::class, 'logout'])->middleware('auth');

Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

Route::post('/users/authenticate', [UserController::class, 'authenticate'])->middleware('guest');

Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show')->middleware('auth');
