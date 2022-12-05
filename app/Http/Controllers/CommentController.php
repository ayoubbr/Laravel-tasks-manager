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
        $task = Task::find($id);
        if ($task->type == 'Master') {
            abort(403, 'Unauthorized action');
        }

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

        $task->duration += $new_comment->duration;
        auth()->user()->duration += $new_comment->duration;
        $task->update();
        auth()->user()->update();
        $parents = self::getParents($task);
        foreach ($parents as $parent) {
            $parent->duration += $new_comment->duration;
            $parent->update();
        }

        return back()->with('message', 'Comment created succefully!');
    }

    public function destroy($id, Comment $comment)
    {
        $comment->delete();
        return back()->with('message', 'Comment deleted succefully!');
    }

    private function getParents($task)
    {
        $tasks = [];
        $parents = Task::with('children')->where('id', $task->parent_id)->get();
        foreach ($parents as $task) {
            $tasks[] = $task;
            $tasks = array_merge($tasks, $this->getParents($task));
        }
        return $tasks;
    }

    public function edit($id)
    {
        $comment = Comment::find($id);
        return view('tasks.edit_comment', compact('comment'));
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        $task = $comment->task;
        $task->duration -= $comment->duration;
        auth()->user()->duration -= $comment->duration;
        $task->update();
        auth()->user()->update();
        $parents = self::getParents($task);
        foreach ($parents as $parent) {
            $parent->duration -= $comment->duration;
            $parent->update();
        }

        $formFields = $request->validate(
            [
                'title' => 'required',
                'description' => 'required',
                'duration' => 'required',
            ]
        );

        foreach ($comment->images as $image) {
            $image->delete();
        }
        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . rand(1, 1000) . '.' . $image->extension();
                $image->move(public_path('comment_imgs'), $imageName);
                CommentImage::create([
                    'comment_id' => $comment->id,
                    'image' => $imageName
                ]);
            }
        }

        $comment->update($formFields);

        $task->duration += $comment->duration;
        auth()->user()->duration += $comment->duration;
        $task->update();
        auth()->user()->update();
        $parents = self::getParents($task);
        foreach ($parents as $parent) {
            $parent->duration += $comment->duration;
            $parent->update();
        }

        return redirect('/tasks')->with('message', 'Comment updated succefully!');
    }
}
