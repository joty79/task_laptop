<?php

namespace App\Http\Controllers;

use App\Models\TaskList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class TaskListController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $taskLists = $user->taskLists()->withCount(['tasks', 'tasks as completed_tasks_count' => function ($query) {
            $query->where('is_completed', true);
        }])->get();

        return view('task-lists.index', compact('taskLists'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        
        TaskList::create($validated);

        return redirect()->route('task-lists.index')->with('success', 'Task list created successfully.');
    }

    public function show(Request $request, TaskList $taskList)
    {
        Gate::authorize('view', $taskList);
        
        $query = $taskList->tasks();

        // Add search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('title', 'LIKE', $search . '%');
        }

        // Filter by completion status
        if ($request->has('status')) {
            if ($request->status === 'completed') {
                $query->where('is_completed', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_completed', false);
            }
        }

        // Sort tasks
        $sortBy = $request->sort ?? 'deadline';
        switch ($sortBy) {
            case 'priority':
                $query->orderByRaw("FIELD(priority, 'high', 'medium', 'low')");
                break;
            case 'deadline':
                $query->orderBy('deadline');
                break;
            case 'completion':
                $query->orderBy('is_completed')->orderBy('deadline');
                break;
        }

        $tasks = $query->get();

        return view('task-lists.show', compact('taskList', 'tasks', 'sortBy'));
    }

    public function destroy(TaskList $taskList)
    {
        Gate::authorize('update', $taskList);
        $taskList->delete();
        return redirect()->route('task-lists.index')->with('success', 'Task list deleted successfully.');
    }

    public function edit(TaskList $taskList)
    {
        Gate::authorize('update', $taskList);
        return view('task-lists.edit', compact('taskList'));
    }

    public function update(Request $request, TaskList $taskList)
    {
        Gate::authorize('update', $taskList);
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
        ]);

        $taskList->update($validated);

        return redirect()->route('task-lists.index')
            ->with('success', 'Task list updated successfully.');
    }
} 