<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{

    public function index()
    {
        $statuses = Status::all();
        return view('settings.index', ['statuses' => $statuses]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $status = new Status();
        $status->name = $request->name;
        $status->save();
        return back();
    }

    public function delete($id)
    {
        Status::find($id)->delete();
        return back();
    }
}
