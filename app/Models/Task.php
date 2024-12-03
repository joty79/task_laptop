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
} 