<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskListController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('task-lists.index');
    })->name('dashboard');

    Route::get('/task-lists', [TaskListController::class, 'index'])->name('task-lists.index');
    Route::post('/task-lists', [TaskListController::class, 'store'])->name('task-lists.store');
    Route::get('/task-lists/{taskList}', [TaskListController::class, 'show'])->name('task-lists.show');
    Route::delete('/task-lists/{taskList}', [TaskListController::class, 'destroy'])->name('task-lists.destroy');
    Route::get('/task-lists/{taskList}/edit', [TaskListController::class, 'edit'])->name('task-lists.edit');
    Route::patch('/task-lists/{taskList}', [TaskListController::class, 'update'])->name('task-lists.update');

    Route::post('/task-lists/{taskList}/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}/toggle-complete', [TaskController::class, 'toggleComplete'])->name('tasks.toggle-complete');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
