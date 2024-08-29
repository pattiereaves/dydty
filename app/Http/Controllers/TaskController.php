<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Household;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        return view('tasks.index', [ 'user' => $user ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Household $household)
    {
        return view('tasks.create', compact('household'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validTaskAttributes = $request->validate([
            'name' => ['required', 'min:3'],
            'completion_interval' => ['required', 'numeric'],
            'household_id' => ['numeric'],
        ]);

        Auth::user()->households()->findOrFail($validTaskAttributes['household_id'])->tasks()->create($validTaskAttributes);

        return redirect('/households/'.$validTaskAttributes['household_id'] );

    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('tasks.show', ['task' => $task ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
