<?php

namespace App\Http\Controllers;

use App\Models\Household;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreHouseholdRequest;
use App\Http\Requests\UpdateHouseholdRequest;


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

        Auth::user()->households()->attach($household);

        return redirect('/households');
    }

    /**
     * Display the specified resource.
     */
    public function show(Household $household)
    {
        //
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
}
