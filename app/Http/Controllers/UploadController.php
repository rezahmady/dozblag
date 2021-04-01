<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function voice(Request $request)
    {
        $blobInput = $request->file('audio-blob');

        $filename = md5(auth()->id().'_'.time()).'.wav';
        //save the wav file to 'storage/app/audio' path with fileanme test.wav
        Storage::disk('local')->put('/.tmb/voice/'.$filename, file_get_contents($blobInput));
        
        return response()->json(['filename'=> $filename]);
    }
}
