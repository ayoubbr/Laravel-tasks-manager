<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    // relationship with user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // relationship with comments
    public function comments()
    {
        return $this->hasMany(Comment::class, 'task_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
