<?php

namespace App\Models;

use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    public function scopeFilter($query, array $filters)
    {
        if ($filters['type'] ?? false) {
            $query->where('type', 'like', '%' . request('type') . '%');
        }

        if ($filters['status'] ?? false) {
            $query->where('status', 'like', '%' . request('status') . '%');
        }

        if ($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('type', 'like', '%' . request('search') . '%')
                ->orWhere('status', 'like', '%' . request('search') . '%');
        }
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'task_id');
    }

    public function uploads()
    {
        return $this->hasMany(Upload::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function children()
    {
        return $this->hasMany(Task::class, 'parent_id')->with('children');
    }

    public static function tree()
    {
        $allTasks = Task::get();

        $rootTasks = $allTasks->whereNull('parent_id');

        self::formatTree($rootTasks, $allTasks);

        return $rootTasks;
    }

    private static function formatTree($tasks, $allTasks)
    {
        foreach ($tasks as $task) {
            $task->children = $allTasks->where('parent_id', $task->id)->values();

            if ($task->children->isNotEmpty()) {
                self::formatTree($task->children, $allTasks);
            }
        }
    }

    public function isChild(): bool
    {
        return $this->parent_id !== null;
    }
}
