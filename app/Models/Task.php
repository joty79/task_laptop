<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_list_id',
        'title',
        'description',
        'priority',
        'deadline',
        'is_completed',
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'is_completed' => 'boolean',
    ];

    public function taskList(): BelongsTo
    {
        return $this->belongsTo(TaskList::class);
    }

    public function getProgressPercentage(): int
    {
        if (!$this->deadline || $this->is_completed) {
            return $this->is_completed ? 100 : 0;
        }

        $start = $this->created_at;
        $end = $this->deadline;
        $now = now();

        if ($now > $end) {
            return 100;
        }

        $totalDuration = $end->diffInSeconds($start);
        $elapsedDuration = $now->diffInSeconds($start);

        return min(100, round(($elapsedDuration / $totalDuration) * 100));
    }

    public function getTimeStatus(): string
    {
        if (!$this->deadline) {
            return 'No deadline';
        }

        if ($this->is_completed) {
            return 'Completed';
        }

        if (now() > $this->deadline) {
            return 'Overdue';
        }

        $daysLeft = intval(now()->diffInDays($this->deadline, false));
        return $daysLeft . ' day' . ($daysLeft != 1 ? 's' : '') . ' left';
    }

    public function getProgressColor(): string
    {
        if ($this->is_completed) {
            return 'bg-green-600';
        }

        if (!$this->deadline) {
            return 'bg-blue-600';
        }

        $totalDays = $this->created_at->diffInDays($this->deadline);
        $daysLeft = now()->diffInDays($this->deadline, false);

        // If overdue
        if ($daysLeft < 0) {
            return 'bg-red-600';
        }

        // Calculate percentage of time remaining
        $percentageLeft = ($daysLeft / $totalDays) * 100;

        // Return color based on time remaining
        if ($percentageLeft > 70) {
            return 'bg-blue-600'; // Lots of time left - Blue
        } elseif ($percentageLeft > 40) {
            return 'bg-yellow-500'; // Getting closer - Yellow
        } else {
            return 'bg-orange-500'; // Almost due - Orange
        }
    }

    public function getElapsedPercentage(): int
    {
        if (!$this->deadline || $this->is_completed) {
            return $this->is_completed ? 100 : 0;
        }

        $start = $this->created_at;
        $end = $this->deadline;
        $now = now();

        if ($now > $end) {
            return 100;
        }

        $totalDuration = $end->diffInSeconds($start);
        $elapsedDuration = $now->diffInSeconds($start);

        return min(100, round(($elapsedDuration / $totalDuration) * 100));
    }
} 