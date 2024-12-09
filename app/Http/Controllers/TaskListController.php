<?php

namespace App\Http\Controllers;

use App\Models\TaskList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        
        // Add search functionality
        $tasks = $taskList->tasks();

        // Apply status filter
        if ($request->has('status')) {
            if ($request->status === 'pending') {
                $tasks = $tasks->where('is_completed', false);
            } elseif ($request->status === 'completed') {
                $tasks = $tasks->where('is_completed', true);
            }
        }

        // Apply sorting
        $sortBy = $request->sort ?? 'deadline';
        $direction = $request->direction === 'desc' ? 'desc' : 'asc';

        switch ($sortBy) {
            case 'priority':
                if ($direction === 'desc') {
                    $tasks = $tasks->orderByRaw("FIELD(priority, 'low', 'medium', 'high')");
                } else {
                    $tasks = $tasks->orderByRaw("FIELD(priority, 'high', 'medium', 'low')");
                }
                break;
            case 'deadline':
                $tasks = $tasks->orderBy('deadline', $direction);
                break;
            case 'completion':
                if ($direction === 'desc') {
                    $tasks = $tasks->orderBy('is_completed', 'desc')->orderBy('deadline', $direction);
                } else {
                    $tasks = $tasks->orderBy('is_completed', 'asc')->orderBy('deadline', $direction);
                }
                break;
            case 'custom':
                $tasks = $tasks->orderBy('sort_order', $direction);
                break;
            default:
                $tasks = $tasks->orderBy('deadline', $direction);
        }

        // Get all tasks and then filter by search if needed
        $tasks = $tasks->get();
        
        if ($request->has('search')) {
            $searchTerm = $request->search;
            Log::info('Search term received:', [
                'raw' => $searchTerm,
                'url_encoded' => urlencode($searchTerm),
                'length' => strlen($searchTerm)
            ]);
            
            $tasks = $tasks->filter(function ($task) use ($searchTerm) {
                $taskTitle = strtolower($task->title);
                $searchTerm = strtolower($searchTerm);
                Log::info('Comparing:', [
                    'title' => $taskTitle,
                    'search' => $searchTerm,
                    'starts_with' => strpos($taskTitle, $searchTerm) === 0
                ]);
                return strpos($taskTitle, $searchTerm) === 0;
            })->values();
        }

        if ($request->ajax()) {
            return view('task-lists.partials.tasks-list', compact('tasks', 'taskList'))->render();
        }

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