<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilesController extends Controller
{
    /**
     * Download a file from the server
     * File location: storage\app\GraceHopper.pdf
     * Computer scientist is the alias name of the file
     *
     */
    public function show() 
    {
        return response()->download(storage_path('app\GraceHopper.pdf'), 'Computer scientist');
    }

    /**
     * This allows us to upload a file to the server
     * Can include other functionality before storing the file like validating it
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request) 
    {
        // '$path' contains the path to the uploaded file
        // 'photo' is the key tagged to the uploaded file
        // 'testing' is where we are storing the file under the 'storage' folder
        $path = $request->file('photo')->store('testing');
        return response()->json(['path' => $path], 200);
    }
}
