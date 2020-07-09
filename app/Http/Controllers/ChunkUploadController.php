<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use App\Models\VM;
use Vbox;

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


    //Chunk upload for VM/Zip files.
    public function chunkStore(Request $request){


        $uploadName = explode('.',$request->input('file'))[0];
        $uploadType = $request->input('file_type');
        $spacedName = str_replace('_', ' ', $uploadName);

        //Check if resources exists + mimetype:
        if((VM::exists($spacedName) && $uploadType === 'application/x-virtualbox-ova')){
            //Check if file expected file exists and return 404
            if(Storage::exists('/vm/'.$request->input('file'))){
                return response()->json(['message'=>'File Exists, Choose another name'], 500);
            }

            $tmpFile = 'API_KEY.chunk';

            //clear out any temp files before uploading
            if(Storage::exists('/tmp/'.$tmpFile) && $request->input('first_chunk') === 'true'){
                Storage::delete('/tmp/'.$tmpFile);
            }
            //Grab data, encode, and store in tmp 
            $data = explode(',',$request->input('file_data'))[1];
            $data = base64_decode($data);
            $path = Storage::path('/tmp/'.$tmpFile);
            File::append($path, $data);

            //Check if chunk is last from user and move file
            if($request->input('final_chunk') === 'true'){
                Storage::move('/tmp/'.$tmpFile,'/vm/'.$uploadName.'.ova');
                //Modify VM and Load OVA.
                if($uploadType === 'application/x-virtualbox-ova'){
                    $vm = VM::find($spacedName);
                    $vm->file = $uploadName.'.ova';
                    $vm->save();

                    Vbox::importVM($uploadName);

                }
                return response()->json(['message' => 'final chunk received, file stored'], 200);
            }

            return response()->json(['message' => 'chunk received'], 200);
        }else{
            return response()->json(['message' => 'upload error'], 500);
        }

    }

    public function test($name){
        Vbox::importVM($name);
    }
}
