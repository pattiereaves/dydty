<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTaskHistoryRequest;
use App\Models\Task;
use App\Models\TaskHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'task_id' => 'required|numeric',
        ]);

        Task::findOrFail($validatedData['task_id'])->histories()->create([
            'user_id' => Auth::user()->id,
            ...$validatedData,
        ]);

        return redirect('/task/'.$validatedData['task_id']);
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskHistory $taskHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskHistory $taskHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskHistoryRequest $request, TaskHistory $taskHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $validatedData = $request->validate([
            'task_id' => 'required|numeric',
        ]);

        Task::findOrFail($validatedData['task_id'])->histories()->first()->delete();

        return redirect('/task/'.$validatedData['task_id']);
    }
}
