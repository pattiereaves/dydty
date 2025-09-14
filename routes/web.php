<?php

use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskHistoryController;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password),
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/register', [RegisteredUserController::class, 'create']);
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('login', [SessionController::class, 'create'])->name('login');
    Route::post('login', [SessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('tasks');
    Route::get('/tasks', function () {
        return redirect('/');
    });

    Route::get('/task/{task}', [TaskController::class, 'show']);
    Route::post('/task/{task}/archive', [TaskController::class, 'archive']);

    Route::get('/households', [HouseholdController::class, 'index']);

    Route::post('/task/{task}/complete', [TaskHistoryController::class, 'store']);
    Route::delete('/task/{task}/uncomplete', [TaskHistoryController::class, 'destroy']);

    Route::get('/households/add', [HouseholdController::class, 'create']);
    Route::post('/households/add', [HouseholdController::class, 'store']);

    Route::get('/households/{household}', [HouseholdController::class, 'show']);

    Route::put('/households/{household}/edit', [HouseholdController::class, 'update']);

    Route::post('/households/{household}/join', [HouseholdController::class, 'join']);
    Route::post('/households/{household}/leave', [HouseholdController::class, 'leave']);
    Route::post('/households/{household}/invite', [HouseholdController::class, 'invite']);

    Route::get('/households/{household}/task/add', [TaskController::class, 'create']);
    Route::post('/households/{household}/task/add', [TaskController::class, 'store']);

    Route::get('/profile/{user}/edit', [RegisteredUserController::class, 'edit'])->name('user.edit');
    Route::put('/profile/{user}/edit', [RegisteredUserController::class, 'update']);

    Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');
});
