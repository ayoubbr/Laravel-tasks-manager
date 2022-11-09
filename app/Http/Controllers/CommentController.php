<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Comment;
use App\Models\CommentImage;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function store(Request $request, $id)
    {
        $formFields = $request->validate(
            [
                'title' => 'required',
                'description' => 'required',
                'duration' => 'required',
            ]
        );
        $formFields['task_id'] = $id;
        $new_comment = Comment::create($formFields);

        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . rand(1, 1000) . '.' . $image->extension();
                $image->move(public_path('comment_imgs'), $imageName);
                CommentImage::create([
                    'comment_id' => $new_comment->id,
                    'image' => $imageName
                ]);
            }
        }
        $task = Task::find($id);
        $task->duration += $new_comment->duration;
        $task->update();
        return back()->with('message', 'Comment created succefully!');
    }

    public function destroy($id, Comment $comment)
    {
        $comment->delete();
        return back()->with('message', 'Comment deleted succefully!');
    }
}
