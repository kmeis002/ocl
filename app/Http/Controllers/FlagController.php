<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Models\VM;
use App\Models\LabFlags;
use App\Models\B2RFlags;
use App\Models\Mqtt;

/*
|--------------------------------------------------------------------------
| Flag Controller
|--------------------------------------------------------------------------
|
| API Endpoint logic for flag submissions and rotations. 
| Initiates Flag Rotation Messaging if marked True in .env file. Default 
| rotation is once a successful flag is submitted by student
|
| Rotations use MQTT to serve up {machine}/{user,root,level#}. Lab/B2R Machines
| must have the listener service installed for flag rotation. 
|
| To-Do:
| - getter Methods??
| - Create timed rotation if set.
|
|
*/


class FlagController extends Controller
{
    
    //Rotates flags (called manually or automatically when )
    public function rotateFlag(Request $request){
    	if(config('flag.rotate')){
    		if(empty($request->input('name')) || empty($request->input('flag')))
    		{
    			return response()->json(['message'=>'Flag rotation requires fields \'name\', and \'flag\''], 400);
     		}
    		$name = $request->input('name');
    		$flag = $request->input('flag');
    		$vm = VM::find($name);

    		$out = $vm->changeFlag($flag);
    		return response()->json(['flag changed' => $out ],200);
    	}
    	return response()->json(['message'=>'Flag rotation is not enabled!'], 500);
    }

    //Checks flag and rotates if config is set to do so (otherwise, rotate manually or timed task)
    public function submitFlag(Request $request){
    	    if(empty($request->input('name')) || empty($request->input('flag')) || empty($request->input('submission')))
    		{
    			return response()->json(['message'=>'Flag rotation requires fields \'name\', \'flag\', and \'submission\''], 400);
     		}
     		$name = $request->input('name');
    		$flag = $request->input('flag');
    		$sub = $request->input('submission');
    		$vm = VM::find($name);

    		if($vm->checkFlag($flag, $sub)){
    			//Add student code here to update their profile
    			if(config('flag.on_submit')){
    				$this->rotateFlag($request);
    			}
    			return response()->json(['flag valid', true], 200);
    		}

    		return response()->json(['flag valid', false], 200);
    }
}
