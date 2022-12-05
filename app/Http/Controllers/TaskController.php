<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Upload;
use App\Models\Comment;
use Illuminate\Support\Str;
use App\Models\CommentImage;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{

    public function index()
    {
        $users = User::get();
        $tasks = Task::tree();
        $statuses = Status::all();
        return view('tasks.index', [
            'tasks' => $tasks,
            'users' => $users,
            'statuses' => $statuses
        ]);
    }

    public function show($id)
    {
        $task = Task::find($id);
        if (!$task) abort(404);
        $uploads = $task->uploads;
        $comments = $task->comments;
        $comment_images = CommentImage::with('comment.task')->whereRelation('comment', 'task_id', $id)->get();
        return view('tasks.details', compact('task', 'uploads', 'comments', 'comment_images'));
    }

    public function create()
    {
        $statuses = Status::all();
        return view(
            'tasks.create',
            [
                'users' => User::get(),
                'statuses' => $statuses,
            ]
        );
    }

    public function store(Request $request)
    {
        $formFields = $request->validate(
            [
                'title' => 'required',
                'status' => 'required',
                'description' => 'required',
            ]
        );

        $formFields['user_id'] = auth()->id();
        $formFields['title'] = Str::title($formFields['title']);
        $formFields['duration'] = 0;
        $formFields['type'] = 'Master';
        $new_task = Task::create($formFields);

        if (
            $request->status == 'open' or $request->status == 'completed'
            or $request->status == 'to validate' or $request->status == 'gestion'
        ) {
            $new_task->userAffectedTo = Null;
        } else {
            $new_task->userAffectedTo = $request->status;
            $new_task->update();
        }

        if ($request->has('uploads')) {
            foreach ($request->file('uploads') as $upload) {
                $uploadName = $formFields['title'] . 'upload-' . time() . rand(1, 1000) . '.' . $upload->extension();
                $upload->move(public_path('task_imgs'), $uploadName);
                Upload::create([
                    'task_id' => $new_task->id,
                    'upload' => $uploadName
                ]);
            }
        }

        $new_task->update();

        return redirect('/tasks')->with('message', 'Task created succefully!');
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
            'description' => 'required',
            'userAffectedTo' => Rule::requiredIf($request->status == 'To Dispatch'),
        ]);

        $formFields['user_id'] = auth()->id();
        $formFields['title'] = Str::title($formFields['title']);
        $formFields['parent_id'] = $task->id;
        $formFields['duration'] = 0;

        $new_task = Task::create($formFields);

        if ($request->status == 'open' or $request->status == 'completed' or $request->status == 'to validate' or $request->status == 'gestion') {
            $new_task->userAffectedTo = Null;
        } else {
            $new_task->userAffectedTo = $request->status;
            $new_task->update();
        }

        if ($new_task->type == 'Normal') {
            Comment::create([
                'task_id' => $new_task->id,
                'title' => 'task from normal task created',
                'description' => $formFields['description'],
                'duration' => 0.2,
            ]);
            $new_task['duration'] = 0.2;
            $new_task->update();
            auth()->user()->duration +=  $new_task['duration'];
            auth()->user()->update();
            $parents = self::getParents($new_task);
            foreach ($parents as $parent) {
                $parent->duration += $new_task->duration;
                $parent->update();
            }
        }

        if ($request->has('uploads')) {
            foreach ($request->file('uploads') as $upload) {
                $uploadName = $formFields['title'] . 'upload-' . time() . rand(1, 1000) . '.' . $upload->extension();
                $upload->move(public_path('task_imgs'), $uploadName);
                Upload::create([
                    'task_id' => $new_task->id,
                    'upload' => $uploadName
                ]);
            }
        }

        return redirect('/tasks')->with('message', 'Child Task created succefully!');
    }

    public function edit(Task $task)
    {
        $statuses = Status::all();
        return view('tasks.edit', [
            'task' => $task,
            'users' => User::get(),
            'statuses' => $statuses
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        $formFields['user_id'] = auth()->id();
        $formFields['title'] = Str::title($formFields['title']);


        if ($task->type != 'Master') {
            if ($task->status != $request->status) {
                $comment = Comment::create([
                    'task_id' => $task->id,
                    'title' => 'title desc',
                    'description' => 'test desc',
                    'duration' => 0.2
                ]);

                auth()->user()->duration += 0.2;
                auth()->user()->update();
            }
        }

        $task->update($formFields);

        if ($request->status == 'Open' or $request->status == 'Completed' or $request->status == 'To Validate' or $request->status == 'Gestion') {
            $task->userAffectedTo = Null;
        } else {
            $task->userAffectedTo = $request->status;
        }

        if ($request->has('uploads')) {
            foreach ($request->file('uploads') as $upload) {
                $uploadName = $formFields['title'] . 'upload-' . time() . rand(1, 1000) . '.' . $upload->extension();
                $upload->move(public_path('task_imgs'), $uploadName);
                Upload::create([
                    'task_id' => $task->id,
                    'upload' => $uploadName
                ]);
            }
        }

        $task->update();

        return redirect('/tasks')->with('message', 'Task updated succefully!');
    }

    public function destroy(Task $task)
    {

        if ($task->user_id != auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        $childrenId = self::getChildren($task);
        foreach ($childrenId as $childId) {
            $tasks = Task::get()->where('id', $childId);
            foreach ($tasks as $task1) {
                $task1->delete();
            }
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
        $statuses = Status::all();

        return view('tasks.create-child', [
            'task' => $task,
            'users' => User::get(),
            'statuses' => $statuses,
        ]);
    }

    public function updateStatus(Request $request, Task $task)
    {
        $formFields = $request->validate([
            'status' => 'required',
        ]);

        $task->update($formFields);

        if (
            $task->status == 'open' or $task->status == 'completed'
            or $task->status == 'to validate' or $task->status == 'gestion'
        ) {
            $task->userAffectedTo = Null;
        } else {
            $task->userAffectedTo = $request->status;
        }
        if ($task->type != 'Master') {
            $comment = Comment::create([
                'task_id' => $task->id,
                'title' => 'title desc',
                'description' => 'test desc',
                'duration' => 0.2
            ]);
            auth()->user()->duration += 0.2;
            auth()->user()->update();
        }

        $task->update();
        return back();
    }

    private function getChildren($task)
    {
        $ids = [];
        $children = Task::with('children')->where('parent_id', $task->id)->get();
        foreach ($children as $task) {
            $ids[] = $task->id;
            $ids = array_merge($ids, $this->getChildren($task));
        }
        return $ids;
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
}
