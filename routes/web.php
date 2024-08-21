<?php

use App\Http\Controllers\HouseholdController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskHistoryController;

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

    Route::get('/households', [HouseholdController::class, 'index']);

    Route::post('/task/{task}/complete', [TaskHistoryController::class, 'store']);
    Route::delete('/task/{task}/uncomplete', [TaskHistoryController::class, 'destroy']);
});

Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');
