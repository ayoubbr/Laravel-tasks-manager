<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function images()
    {
        return $this->hasMany(CommentImage::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
