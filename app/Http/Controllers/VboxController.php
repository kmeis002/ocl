<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\VM;
use Vbox;

/*
|--------------------------------------------------------------------------
| VMVisor Controller
|--------------------------------------------------------------------------
|
| API Methods for VM Models. Includes loading into system, activating,
| controlling/modifying VM Settings, resets and more. Assumes backend server
| is using VirtualBox (vboxmanage)
|
| To-Do:
| - MQTT Server for VM Control
| - Implement other hypervisors
*/


class VboxController extends Controller
{
    //Loads VM into virtualbox
    public function showAllVMs(Request $request){
    	return Vbox::getAllVMs();
    }

    public function test(Request $request){
    	$vm = VM::find('ubuntu-server');
    	//$vm->turnOff();
    	$vm->unregisterVM();
    }

  	public function status(Request $request){
        $request->validate([
            'known_status' => 'required',
            'vm_name' => 'required',
        ]);

        if($request->input('known_status') === 'on'){
             $lastStatus = 1;
        }else{
             $lastStatus = 0;
        }

        $name = $request->input('vm_name');

        $vm = VM::find($name);

        if($vm->status === $lastStatus){
            return response()->json(['status' => $request->input('known_status'), 'msg' => '']);
        }

        if($vm->status === 0){
            return response()->json(['status' => 'off', 'msg' => 'Machine is now powered off']);
        }


        if($vm->status === 1){
            return response()->json(['status' => 'on', 'msg' => 'Machine is now powered on']);
        }
    }

}
