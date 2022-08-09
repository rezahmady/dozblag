<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function file(Request $request)
    {

        if($request->hasFile('file')) {
            $file = $request->file('file');
            $prefix = $request->prefix;
            $filename = $prefix.$file->getClientOriginalName();
            Storage::disk('local')->put('/uploads/'.$filename, file_get_contents($file));
            // $file->storeAs('/uploads/', $filename);
        }
        
        return response()->json([
            'id' => $filename,
            'name' => $filename,
            'url' => asset('/uplouds/'.$filename)
        ]);
    }
}
