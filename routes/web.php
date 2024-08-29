<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\TaskHistoryController;
use App\Http\Controllers\RegisteredUserController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create']);
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('login', [SessionController::class, 'create'])->name('login');
    Route::post('login', [SessionController::class, 'store']);
});


Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index']);

    Route::get('/task/{task}', [TaskController::class, 'show']);

    Route::get('/households', [HouseholdController::class, 'index']);

    Route::post('/task/{task}/complete', [TaskHistoryController::class, 'store']);
    Route::delete('/task/{task}/uncomplete', [TaskHistoryController::class, 'destroy']);

    Route::get('/households/add', [HouseholdController::class, 'create']);
    Route::post('/households/add', [HouseholdController::class, 'store']);

    Route::get('/households/{household}', [HouseholdController::class, 'show']);

    Route::post('/households/{household}/join', [HouseholdController::class, 'join']);
    Route::post('/households/{household}/leave', [HouseholdController::class, 'leave']);

    Route::get('/households/{household}/task/add', [TaskController::class, 'create']);
    Route::post('/households/{household}/task/add', [TaskController::class, 'store']);
});

Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');
