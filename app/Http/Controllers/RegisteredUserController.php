<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'confirmed'],
            'password' => ['required', Password::min(6), 'confirmed'],
        ]);

        $user = User::create($attributes);

        Auth::login($user);

        return redirect('/');
    }

    public function edit(User $user)
    {
        if ($user->id !== Auth::user()->id) {
            return redirect('/');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validAttributes = $request->validate([
            'email' => ['required', 'email', 'confirmed'],
            'name' => ['required', 'min:3'],
            'password' => ['nullable', Password::min(6), 'confirmed'],
        ]);

        if (Auth::user()->id !== $user->id) {
            throw ValidationException::withMessages([
                'You can only edit your own profile',
            ]);
        }

        $user->update([
            'name' => $validAttributes['name'],
            'email' => $validAttributes['email'],
            'password' => empty($validAttributes['password']) ? $user->password :
                bcrypt($validAttributes['password']),
        ]);

        return redirect()->route('user.edit', ['user' => $user])->with('success', 'Profile updated successfully');
    }

    public function loggedOut()
    {
        return redirect()->route('login');
    }
}
