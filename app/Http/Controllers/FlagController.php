<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\VM;
use App\Models\LabFlags;
use App\Models\B2RFlags;
use App\Models\Ctfs;
use App\Models\CompletedLabFlags;
use App\Models\CompletedB2RFlags;
use App\Models\CompletedCtfs;
use App\Models\Mqtt;

/*
|--------------------------------------------------------------------------
| Flag Controller
|--------------------------------------------------------------------------
|
| Endpoint logic for flag submissions and rotations. 
| Initiates Flag Rotation Messaging if marked True in .env file. Default 
| rotation is once a successful flag is submitted by student
|
| Rotations use MQTT to serve up {machine}/{user,root,level#}. Lab/B2R Machines
| must have the listener service installed for flag rotation. 
|
|
|
*/


class FlagController extends Controller
{
    
    //Rotates flags (called manually or automatically when )
    public function apiRotateFlag(Request $request){
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
    public function submitFlag(Request $request, $name){

        $request->validate([
            'flag' => 'required',
            'type' => ['required'],
        ]);

        $student = Auth::user()['name'];

        if(VM::find($name)->status || !config('flag.rotate')){
            //check flag
            if($request->input('type') === 'lab'){
                $realFlag = LabFlags::where(['lab_name' => $name, 'level' => $request->input('flagId')])->get()[0]['flag'];

            }elseif($request->input('type') === 'b2r'){
                $realFlag = B2RFlags::where(['b2r_name' => $name])->get()[0][$request->input('flagId')];
            }elseif($request->input('type') === 'ctf'){
                $realFlag = Ctfs::find($name)['flag'];
            }

            if($realFlag === $request->input('flag')){
                if(config('flag.rotate') && $request->input('type') !== 'ctf'){
                    $this->rotateFlag($name, $request->input('flagId'));
                }

                if($request->input('type') === 'lab'){
                    CompletedLabFlags::create([
                        'student' => $student,
                        'lab_name' => $name,
                        'level' => $request->input('flagId'),
                    ]);
                    return response()->json(['message' => 'Correct flag'], 200);
                }elseif($request->input('type') === 'b2r'){
                    CompletedB2RFlags::create([
                        'student' => $student,
                        'b2r_name' => $name,
                        'is_root' => $request->input('flagId') === 'root_flag',
                    ]);
                    return response()->json(['message' => 'Correct flag'], 200);
                }elseif($request->input('type') === 'ctf'){
                    CompletedCtfs::create([
                        'student' => $student,
                        'ctf_name' => $name,
                    ]);
                    return response()->json(['message' => 'Correct flag'], 200);
                }
            }else{
                    return response()->json(['message' => 'Incorrect flag'], 200);
            }
        }
    }

    //Helper function for flag check
    private function rotateFlag($name, $flag){
        $vm = VM::find($name);
        return $vm->changeFlag($flag);
    }

    public function apiLevelCreate(Request $request, $name){
        $levelCount = LabFlags::where(['lab_name'=>$name])->count();

        LabFlags::create([
            'lab_name' => $name,
            'level' => $levelCount+1,
            'flag' => md5(Str::random(config('flag_random'))),
        ]);
    }

    public function apiLevelDestroy($name, $id){
        $level = LabFlags::find($id)['level'];
        if($level === LabFlags::where(['lab_name'=>$name])->count()){
            $flag = LabFlags::find($id);
            $flag->delete();
        }else{
            return response()->json(['message'=>'You can only delete the last known level for a lab. Please modify existing flags.']);
        }
    }
}
