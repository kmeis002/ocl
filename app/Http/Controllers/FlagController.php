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
| - Add some callback to confirm flag rotation (MQTT Subscribe doesn't seem like a great option)
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
     		//make mqtt object
     		$mqtt = new Mqtt();

    		$name = $request->input('name');
    		$flag = $request->input('flag');
    		$vm = VM::find($name);

    		if(!$this->machineCheck($name)){
    			return response()->json(['message'=>'You must select an activated machine'], 400);
    		}

			//Rotate B2R
    		if($vm->isB2R()){
    			$newflag = $vm->changeFlag($flag);	

    			//Send MQTT message to machine			
    			if($mqtt->publish($name.'/'.$flag, $newflag)){
    				return response()->json(['message'=>'flag changed'], 200);
    			}
    		}

    		//Rotate Lab Flag
    		if($vm->isLab()){
    			$newflag = $vm->changeFlag($flag);

    			if($mqtt->publish($name.'/level'.$flag, $newflag)){
    				return response()->json(['message'=>'flag changed'], 200);
    			}
    		}

    		return response()->json(['message'=>'Some Error', 'name' => $name, 'type' => $type], 500);
    	}
    	return response()->json(['message'=>'Flag rotation is not enabled!'], 500);
    }

    public function checkFlag(Request $request){

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
