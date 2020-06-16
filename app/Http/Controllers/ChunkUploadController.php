<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;



/*
|--------------------------------------------------------------------------
| ChunkUploadController
|--------------------------------------------------------------------------
|
| API Controller for handling Chunk Uploads from chunkupload.js
| To do:
| - Add folder structure / upload for different mime types
|
*/


class ChunkUploadController extends Controller
{


   	public function chunkTest(){
        return 'testing';
    }

    //Chunk upload for VM (need to handle multiple mime types) files.
    public function chunkStore(Request $request){

        //Check if file expected file exists and return 404
        if(Storage::exists('/vm/'.$request->input('file'))){
            return response()->json(['message'=>'File Exists, Choose another name'], 500);
        }

        
        //Grab data, encode, and store in tmp 
        $data = explode(',',$request->input('file_data'))[1];
        $data = base64_decode($data);
        $path = Storage::path('/tmp/'.$request->input('api_token').'.chunk');
        File::append($path, $data);

        //Check if chunk is last from user and move file
        if($request->input('final_chunk') === 'true'){
            Storage::move('/tmp/'.$request->input('api_token').'.chunk','/vm/'.$request->input('file'));
            return response()->json(['message' => 'final chunk received, file stored'], 200);
        }

        return response()->json(['message' => 'chunk received'], 200);

        /*
        $file = $request->file('file');

        //store chunk
        $path = Storage::disk('local')->path("chunks/{$file->getClientOriginalName()}");

        //String together chunks
        File::append($path, $file->get());


        //finalize chunk
        if ($request->has('is_last') && $request->boolean('is_last')) {
            $name = basename($path, '.part');

            //File::move($path, "/path/to/public/someid/{$name}");
        }


        return response()->json(['uploaded' => true]);
        */
    }
}
