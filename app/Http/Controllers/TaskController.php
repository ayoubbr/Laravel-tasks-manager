<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Upload;
use App\Models\Comment;
use Illuminate\Support\Str;
use App\Models\CommentImage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{

    public function index()
    {
        $users = User::get();
        $tasks = Task::tree();
        return view('tasks.index', [
            'tasks' => $tasks,
            'users' => $users
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
                'title' => 'required',
                'type' => 'required',
                'status' => 'required',
                'userAffectedTo' => Rule::requiredIf($request->status == 'To Dispatch'),
            ]
        );

        $formFields['user_id'] = auth()->id();
        $formFields['title'] = Str::title($formFields['title']);
        $formFields['duration'] = 0;
        $new_task = Task::create($formFields);
        $commentFields = $request->validate(['description' => 'required',]);

        if ($new_task->type == 'Normal') {
            Comment::create([
                'task_id' => $new_task->id,
                'title' => 'Comment Created Automatically With a Normal Task',
                'description' => $commentFields['description'],
                'duration' => 0.2,
            ]);
            $new_task['duration'] = 0.2;
            $new_task->update();
            auth()->user()->duration +=  $new_task['duration'];
            auth()->user()->update();
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

        if ($new_task->status !== 'To Dispatch') {
            $new_task->userAffectedTo = null;
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
            'userAffectedTo' => Rule::requiredIf($request->status == 'To Dispatch'),
            'duration' => ''
        ]);

        $formFields['user_id'] = auth()->id();
        $formFields['title'] = Str::title($formFields['title']);
        $formFields['parent_id'] = $task->id;
        $formFields['duration'] = 0;

        $new_task = Task::create($formFields);
        $commentFields = $request->validate(['description' => 'required',]);

        if ($new_task->type == 'Normal') {
            Comment::create([
                'task_id' => $new_task->id,
                'title' => 'task from normal task created',
                'description' => $commentFields['description'],
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

        // if ($new_task->type == 'Master') {
        //     $new_task->parent_id = null;
        //     $new_task->update();
        // }

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
        return view('tasks.edit', [
            'task' => $task,
            'users' => User::get(),
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $formFields = $request->validate([
            'title' => 'required',
            // 'type' => 'required',
            'status' => 'required',
            'userAffectedTo' => Rule::requiredIf($request->status == 'To Dispatch'),
        ]);

        $formFields['user_id'] = auth()->id();
        $formFields['title'] = Str::title($formFields['title']);

        // if ($task->type == 'Normal') {
        //     Comment::create([
        //         'task_id' => $task->id,
        //         'title' => 'Updated task!',
        //         'description' => 'This is an Updated task! ',
        //         'duration' => 0.2,
        //     ]);
        // if ($task->status == 'To Dispatch') {
        //     Comment::create([
        //         'task_id' => $task->id,
        //         'title' => 'This is an Automatic Comment!',
        //         'description' => 'A user created a task',
        //         'duration' => 0.2,
        //     ]);
        // }
        // }

        // if ($request->has('images')) {
        //     foreach ($request->file('images') as $image) {
        //         $imageName = $formFields['title'] . 'image-' . time() . rand(1, 1000) . '.' . $image->extension();
        //         $image->move(public_path('task_imgs'), $imageName);
        //         Image::create([
        //             'task_id' => $task->id,
        //             'image' => $imageName
        //         ]);
        //     }
        // }

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



        $task->update($formFields);
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
        return view('tasks.create-child', [
            'task' => $task,
            'users' => User::get(),
        ]);
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
