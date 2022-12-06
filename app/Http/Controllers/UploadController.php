<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Upload;

class UploadController extends Controller
{

    public function destroy($id)
    {
        $upload = Upload::find($id);
        $upload->delete();
        return back()->with('message', 'Upload deleted succefully!');
    }
}
