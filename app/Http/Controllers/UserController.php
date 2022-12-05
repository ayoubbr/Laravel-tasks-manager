<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function create()
    {
        return view('users.register');
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:4'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:5'
        ]);

        $formFields['name'] = Str::title($formFields['name']);
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        // Create User
        $user = User::create($formFields);

        // Login
        auth()->login($user);

        return redirect('/')->with('message', 'User created and logged in');
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'You have been logged out!');
    }

    public function login()
    {
        return view('users.login');
    }

    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();
            return redirect('/tasks')->with('message', 'You are now logged in!');
        }

        return back()->withErrors(['email' => 'Invalid Credentials']);
    }

    public function manage()
    {
        $users = User::all();
        $tasks = Task::all();
        return view('users.manage',  [
            'users' => $users,
            'tasks' => $tasks,
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);
        $tasks = Task::where('userAffectedTo',  $user->name)->get();
        $day = '';
        $month = '';
        $year = '';

        return view('users.show', [
            'user' => $user,
            'tasks' => $tasks,
            'day' => $day,
            'month' => $month,
            'year' => $year,
        ]);
    }

    public function edit($id)
    {
        $user = User::find($id);

        return view('users.edit', [
            'user' => $user,
        ]);
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('/users')->with('message', 'User deleted successfully!');
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->file('logo')) {
            $file = $request->file('logo');
            @unlink(public_path('storage/logos/' . $user->logo));
            $filename = '2022' . date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('storage/logos/'), $filename);
            $user['logo'] = $filename;
        }
        $user->save();
        return redirect('/users')->with('message', 'User Updated Succesfully');
    }

    public function filter(Request $request, $id)
    {
        $user = User::find($id);
        $tasks = Task::where('userAffectedTo',  $user->name)->get();
        $day = $request->day;
        $month = $request->month;
        $year = $request->year;
        $array = [];
        foreach ($tasks as $task) {
            if (str_contains($task->updated_at, $month) && str_contains($task->updated_at, $day) && str_contains($task->updated_at, $year)) {
                array_push($array, $task);
            }
        }
        $tasks = $array;
        return view('users.show', compact('tasks', 'user', 'day', 'month', 'year'));
    }
}
