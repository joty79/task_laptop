<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function store(Request $request, TaskList $taskList)
    {
        Gate::authorize('update', $taskList);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'deadline' => [
                'required',
                'date',
                'after_or_equal:today'
            ],
        ], [
            'deadline.required' => 'The deadline field is required.',
            'deadline.after_or_equal' => 'The deadline must be today or a future date.'
        ]);

        $taskList->tasks()->create($validated);

        return redirect()->route('task-lists.show', $taskList)
            ->with('success', 'Task created successfully.');
    }

    public function toggleComplete(Task $task)
    {
        Gate::authorize('update', $task->taskList);
        
        $task->update([
            'is_completed' => !$task->is_completed
        ]);

        return back()->with('success', 'Task status updated.');
    }

    public function destroy(Task $task)
    {
        Gate::authorize('update', $task->taskList);
        $task->delete();
        return back()->with('success', 'Task deleted successfully.');
    }

    public function edit(Task $task)
    {
        Gate::authorize('update', $task->taskList);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        Gate::authorize('update', $task->taskList);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'deadline' => [
                'required',
                'date',
                'after:today'
            ]
        ]);

        $task->update($validated);

        return redirect()
            ->route('task-lists.show', $task->taskList)
            ->with('success', 'Task updated successfully.');
    }
} 