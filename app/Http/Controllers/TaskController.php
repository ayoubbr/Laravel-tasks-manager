<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Image;
use App\Models\Comment;
use Illuminate\Support\Str;
use App\Models\CommentImage;
use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{

    public function index()
    {

        $tasks = Task::tree();
        $users = User::get();
        return view('tasks.index', [
            'tasks' => $tasks,
            'users' => $users
        ]);
    }

    public function show($id)
    {
        $task = Task::find($id);
        if (!$task) abort(404);
        $images = $task->images;
        $comments = $task->comments;
        $comment_images = CommentImage::with('comment.task')->whereRelation('comment', 'task_id', $id)->get();
        return view('tasks.details', compact('task', 'images', 'comments', 'comment_images'));
    }

    public function create()
    {
        return view(
            'tasks.create',
            [
                'users' => User::get(),
            ]
        );
    }

    public function store(Request $request)
    {
        $formFields = $request->validate(
            [
                'title' => ['required',],
                'type' => 'required',
                'status' => 'required',
                'userAffectedTo' => Rule::requiredIf($request->status == 'To Dispatch'),
                'duration' => ''
            ]
        );

        $formFields['user_id'] = auth()->id();
        $formFields['title'] = Str::title($formFields['title']);
        $formFields['duration'] = 0;
        $new_task = Task::create($formFields);

        if ($new_task->type == 'Normal') {
            Comment::create([
                'task_id' => $new_task->id,
                'title' => 'Automatic Comment',
                'description' => 'This Comment generated automatically!',
                'duration' => 0.2,
            ]);

            if ($new_task->status == 'To Dispatch') {
                Comment::create([
                    'task_id' => $new_task->id,
                    'title' => 'Automatic Comment',
                    'description' => 'This Comment generated automatically!',
                    'duration' => 0.2,
                ]);
            }
        }

        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = $formFields['title'] . 'image-' . time() . rand(1, 1000) . '.' . $image->extension();
                $image->move(public_path('task_imgs'), $imageName);
                Image::create([
                    'task_id' => $new_task->id,
                    'image' => $imageName
                ]);
            }
        }

        if ($new_task->status !== 'To Dispatch') {
            $new_task->userAffectedTo = null;
        }

        $new_task->update();

        return redirect('/tasks')->with('message', 'Task created succefully!');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', [
            'task' => $task,
            'users' => User::get(),
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'type' => 'required',
            'status' => 'required',
            'userAffectedTo' => Rule::requiredIf($request->status == 'To Dispatch'),
        ]);

        $formFields['user_id'] = auth()->id();
        $formFields['title'] = Str::title($formFields['title']);

        if ($task->type == 'Normal') {
            Comment::create([
                'task_id' => $task->id,
                'title' => 'This is an Automatic Comment!',
                'description' => 'A user created a task',
                'duration' => 0.2,
            ]);
            if ($task->status == 'To Dispatch') {
                Comment::create([
                    'task_id' => $task->id,
                    'title' => 'This is an Automatic Comment!',
                    'description' => 'A user created a task',
                    'duration' => 0.2,
                ]);
            }
        }

        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = $formFields['title'] . 'image-' . time() . rand(1, 1000) . '.' . $image->extension();
                $image->move(public_path('task_imgs'), $imageName);
                Image::create([
                    'task_id' => $task->id,
                    'image' => $imageName
                ]);
            }
        }

        $task->update($formFields);
        return redirect('/tasks')->with('message', 'Task updated succefully!');
    }

    public function destroy(Task $task)
    {

        if ($task->user_id != auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        $task->delete();
        return redirect('/tasks')->with('message', 'Task deleted succefully!');
    }

    public function manage()
    {
        return view(
            'tasks.manage',
            [
                'tasks' => auth()->user()->tasks()->latest()
                    ->filter(request(['type', 'search']))
                    ->filter(request(['status']))
                    ->paginate(6)
            ]
        );
    }

    public function home()
    {
        $tasks = Task::tree();
        return view('home', [
            'tasks' => $tasks
        ]);
    }

    public function createChild(Task $task)
    {
        return view('tasks.create-child', [
            'task' => $task,
            'users' => User::get(),
        ]);
    }

    public function storeChild(Request $request, Task $task)
    {
        if ($task->type == 'Normal') {
            abort(403, 'Unauthorized action');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'type' => 'required',
            'status' => 'required',
            'userAffectedTo' => Rule::requiredIf($request->status == 'To Dispatch'),
            'duration' => ''
        ]);

        $formFields['user_id'] = auth()->id();
        $formFields['title'] = Str::title($formFields['title']);
        $formFields['parent_id'] = $task->id;
        $formFields['duration'] = 0.2;
        $task->duration += $formFields['duration'];
        $task->update();
        $new_task = Task::create($formFields);


        if ($new_task->type == 'Master') {
            $new_task->parent_id = null;
        }
        if ($new_task->type == 'Normal') {
            Comment::create([
                'task_id' => $new_task->id,
                'title' => 'Automatic Comment',
                'description' => 'This Comment generated automatically!',
                'duration' => 0.2,
            ]);
            if ($new_task->status == 'To Dispatch') {
                Comment::create([
                    'task_id' => $new_task->id,
                    'title' => 'Automatic Comment',
                    'description' => 'This Comment generated automatically!',
                    'duration' => 0.2,
                ]);
            }
        }

        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = $formFields['title'] . 'image-' . time() . rand(1, 1000) . '.' . $image->extension();
                $image->move(public_path('task_imgs'), $imageName);
                Image::create([
                    'task_id' => $task->id,
                    'image' => $imageName
                ]);
            }
        }


        return redirect('/tasks')->with('message', 'Child Task updated succefully!');
    }


    public function updateStatus(Request $request, Task $task)
    {

        $formFields = $request->validate([
            'status' => 'required',
            'userAffectedTo' => Rule::requiredIf($request->status == 'To Dispatch'),
        ]);

        $task->update($formFields);
        if ($task->status != 'Open' && $task->status != 'Completed' && $task->status != 'To Validate') {
            $task->userAffectedTo = $task->status;
            $task->status = 'To Dispatch';
        } else {
            $task->userAffectedTo = null;
        }
        $task->update();
        return back();
    }
}
