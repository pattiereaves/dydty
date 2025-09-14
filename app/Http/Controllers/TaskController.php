<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTaskRequest;
use App\Models\Household;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $households = $user->households()
            ->with(['tasks'])
            ->withPivot('invitation_pending')
            ->orderBy('household_user.invitation_pending', 'desc')
            ->get();

        return view('tasks.index', compact('user', 'households'));
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

        return redirect('/tasks');

    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load('histories.user');

        return view('tasks.show', compact('task'));
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

    public function archive(Request $request)
    {
        $currentUser = Auth::user();
        $task = Task::findOrFail($request->get('task_id'));

        // Check that the user belongs to the household that owns the task
        if (! $currentUser->households->contains($task->household)) {
            throw ValidationException::withMessages([
                'You are not authorized to archive this task',
            ]);
        }

        $task->update([
            'is_active' => false,
        ]);

        return redirect('/tasks');
    }
}
