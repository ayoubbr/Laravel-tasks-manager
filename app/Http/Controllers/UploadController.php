<?php

namespace App\Http\Controllers;

use App\Models\Upload;

class UploadController extends Controller
{

    public function destroy($id, Upload $upload)
    {
        $upload->delete();
        return back()->with('message', 'Upload deleted succefully!');
    }
}
