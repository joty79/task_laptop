<?php

namespace App\Policies;

use App\Models\TaskList;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskListPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TaskList $taskList): bool
    {
        return $user->id === $taskList->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TaskList $taskList): bool
    {
        return $user->id === $taskList->user_id;
    }

    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        return null;
    }
} 