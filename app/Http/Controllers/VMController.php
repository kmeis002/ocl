<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\VM;

/*
|--------------------------------------------------------------------------
| Virtual Machine Controller
|--------------------------------------------------------------------------
|
|
|
*/



class VMController extends Controller
{

    private $path = '/vm/';

    public function __construct(){
    	//$this->middleware('auth:teacher');
    }

    public function apiDeleteOva($name){
        $fullPath = storage_path('app').$this->path;
        $vm = VM::find($name);
        if(File::exists($fullPath.$vm['file'])){
            File::delete($fullPath.$vm['file']);
            if(!File::exists($fullPath.$vm['file'])){
                $vm->file = NULL;
                $vm->save();
                return response()->json(['message' => 'File deleted', 'file' => $vm->file], 200);
            }else{
                return response()->json(['message' => 'File '.$fullPath.$vm['file'].' couldn\'t be deleted'], 500);
            }
        }else{
            return response()->json(['message' => 'File: '.$fullPath.$vm['file'].' doesn\'t exist'], 500);
        }
    }


}


