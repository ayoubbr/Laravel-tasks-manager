<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Image;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{

    public function index()
    {
        return view('tasks.index', [
            'tasks' => Task::latest()
                ->filter(request(['type', 'search']))
                ->filter(request(['status']))
                ->paginate(6)
        ]);
    }

    public function show($id)
    {
        $task = Task::find($id);
        if (!$task) abort(404);
        $images = $task->images;
        $comments = $task->comments;
        return view('tasks.details', compact('task', 'images', 'comments'));
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
            ]
        );

        $formFields['user_id'] = auth()->id();
        $new_task = Task::create($formFields);

        if ($new_task->type == 'Normal') {
            Comment::create([
                'task_id' => $new_task->id,
                'description' => 'This is a Normal Task!'
            ]);
            if ($new_task->status == 'To Dispatch') {
                Comment::create([
                    'task_id' => $new_task->id,
                    'description' => 'This is a task that has a status of To Dispatch!'
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


        return redirect('/tasks')->with('message', 'Task created succefully!');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', ['task' => $task]);
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id != auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'type' => 'required',
            'status' => 'required',
        ]);
        $task->update($formFields);
        return back()->with('message', 'Task updated succefully!');
    }

    public function destroy(Task $task)
    {

        if ($task->user_id != auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        $task->delete();
        return redirect('/tasks/manage')->with('message', 'Task deleted succefully!');
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
}
