<?php

namespace App\Http\Controllers;

use App\Models\Task;
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
    public function show(Task $task)
    {
        return view('tasks.show', [
            'task' => $task
        ]);
    }

    public function create()
    {
        return view('tasks.create');
    }
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => ['required', Rule::unique('tasks', 'title')],
            'type' => 'required',
            'status' => 'required ',
            'uploads' => 'required',
            'comments' => 'required',
        ]);

        $formFields['user_id'] = auth()->id();
        Task::create($formFields);
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
            'uploads' => 'required',
            'comments' => 'required',
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
        return redirect('/tasks')->with('message', 'Task deleted succefully!');
    }
    public function manage()
    {
        return view(
            'tasks.manage',
            [
                'tasks' =>
                auth()->user()->tasks()->paginate(6)
            ]
        );
    }
}
