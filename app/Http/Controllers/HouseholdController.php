<?php

namespace App\Http\Controllers;

use App\Models\Household;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreHouseholdRequest;
use App\Http\Requests\UpdateHouseholdRequest;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class HouseholdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $otherHouseholds = Household::all()->filter(function ($household) {
            return !$household->users()->find(Auth::user());
        });

        return view('households.index', [
            'userHouseholds' => Auth::user()->households,
            'otherHouseholds' => $otherHouseholds,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('households.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {

        $validAttributes = request()->validate([
            'name' => ['required', 'min:4'],
        ]);

        $household = Household::create($validAttributes);

        Auth::user()->households()->attach($household, ['invitation_pending' => false]);

        return redirect('/households');
    }

    /**
     * Display the specified resource.
     */
    public function show(Household $household)
    {
        return view('households.show', compact('household'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Household $household)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHouseholdRequest $request, Household $household)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Household $household)
    {
        //
    }

    public function join(Household $household)
    {
        $user = Auth::user();

        $household->users()->attach($user, ['invitation_pending' => false]);

        return redirect('households/'.$household->id);
    }

    public function leave(Household $household)
    {
        // User must belong to household to remove a member.
        $currentUser = Auth::user();

        if (!$currentUser->households->contains($household)) {
            throw ValidationException::withMessages([
                "You can't remove members of a house to which you don't belong.",
            ]);
        }

        $userId = request()->get('user_id');

        $user = is_numeric($userId) ?
            User::findOrFail($userId) :
            Auth::user();

        $household->users()->detach($user);

        return redirect('households/'.$household->id);
    }

    public function invite(Household $household)
    {
        $validAttributes = request()->validate([
            'email' => ['email'],
        ]);

        // Check if a user exists.
        $user = User::where('email', $validAttributes['email'])->first();

        // If a user does not exist, create one.
        if (!$user) {
            $user = User::create([
                'email' => $validAttributes['email'],
                'name' => '',
                'password' => bcrypt(str()->random(16)),
            ]);
        }

        // If user is already a member of this household, throw exception.
        if ($household->users()->where('email', $validAttributes['email'])->first()) {
            if ($user->households()->find($household->id)->pivot->invitation_pending) {
                throw ValidationException::withMessages([
                    'email' => 'User has pending invitation',
                ]);
            }

            throw ValidationException::withMessages([
                'email' => 'User already is a member of this household',
            ]);
        }

        // Attach that user to the household.
        $user->households()->attach($household, ['invitation_pending' => true]);

        // Send the user an email to create their account.

        // Redirect to household page.
        return redirect('households/'.$household->id);
    }
}
