<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

     // relationship with task
    //  public function task(){
    //     return $this->belongsTo(Task::class, 'task_id');
    // }
}