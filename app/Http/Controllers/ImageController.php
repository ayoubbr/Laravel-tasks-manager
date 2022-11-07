<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{

    public function destroy($id, Image $image)
    {
        $image->delete();
        return back()->with('message', 'Image deleted succefully!');
    }
}
