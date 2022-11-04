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
                'description' => 'required',
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

        return back()->with('message', 'Comment created succefully!');
    }




























    // $new_comment = 

    // if ($new_task->type == 'Normal') {
    //     Comment::create([
    //         'task_id' => $new_task->id,
    //         'description' => 'This is a Normal Task!'
    //     ]);
    //     if ($new_task->status == 'To Dispatch') {
    //         Comment::create([
    //             'task_id' => $new_task->id,
    //             'description' => 'This is a task that has a status of To Dispatch!'
    //         ]);
    //     }
    // }

    // if ($request->has('images')) {
    //     foreach ($request->file('images') as $image) {
    //         $imageName = $formFields['title'] . 'image-' . time() . rand(1, 1000) . '.' . $image->extension();
    //         $image->move(public_path('task_imgs'), $imageName);
    //         Image::create([
    //             'task_id' => $new_task->id,
    //             'image' => $imageName
    //         ]);
    //     }
    // }
    // }
}
