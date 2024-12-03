<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskList extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function completedTasksCount()
    {
        return $this->tasks()->where('is_completed', true)->count();
    }

    public function totalTasksCount()
    {
        return $this->tasks()->count();
    }

    public function progressPercentage()
    {
        $total = $this->totalTasksCount();
        if ($total === 0) return 0;
        
        return round(($this->completedTasksCount() / $total) * 100);
    }
} 