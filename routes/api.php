<?php

use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserController::class, 'login']);
Route::post('/users', [UserController::class, 'store']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/profile', [UserController::class, 'profile']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    //task
    Route::get('get/task', [TaskController::class, 'index']);
    Route::post('add/task', [TaskController::class, 'store']);
    Route::get('single/{id}/task', [TaskController::class, 'show']);
    Route::get('task/{id}/edit', [TaskController::class, 'edit']);
    Route::put('/task/{id}/update', [TaskController::class, 'update']);
    Route::delete('/task/{id}/delete', [TaskController::class, 'destroy']);
   
});

Route::get('/login', function () {
    return response()->json([
        'status' => false,
        'message' => 'You have been Loggedout Plese First Login !',
    ], 401);
})->name('login');
