<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create']);
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [SessionController::class, 'create']);
    Route::post('/login', [SessionController::class, 'store']);

});

Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/task/{task}', [TaskController::class, 'show']);
});

Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');
