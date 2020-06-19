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

    		if(!$this->machineCheck($name)){
    			return response()->json(['message'=>'You must select an activated machine'], 400);
    		}

			//Rotate B2R
    		if($vm->isB2R()){
    			return response()->json(['flag changed' => $vm->changeFlag($flag)],200);
    		}

    		//Rotate Lab Flag
    		if($vm->isLab()){
    			return response()->json(['flag changed' => $vm->changeFlag($flag) ],200);
    		}

    		return response()->json(['message'=>'Some Error', 'name' => $name, 'type' => $type], 500);
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

    #Returns true of machine exists and is on
    private function machineCheck($name){
    	$vm = VM::find($name);
    	return ($vm != null && !$vm['status']);
    }

    public function mqttSubTest(){
    	$mqtt = new Mqtt();
    	$out = $mqtt->waitForResponse('B2RTest/response');
    	return response()->json(['out', $out], 200);
    }




}
