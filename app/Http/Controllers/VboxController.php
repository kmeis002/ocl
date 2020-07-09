<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Vbox;
use App\Models\VM;

/*
|--------------------------------------------------------------------------
| Vbox Controller
|--------------------------------------------------------------------------
|
| api endpoints for Virtual Machine information/modification
|
*/


class VBoxController extends Controller
{
    public function apiGetInfo($name){
    	$isReg = Vbox::isRegistered($name);
    	$netInt = Vbox::getNetworkInterface($name, 'NIC 1');
        $status = VM::find($name)['status'];
    	return response()->json(['registered' => $isReg, 'NIC 1' => $netInt, 'status' => $status]);
    }

    public function apiGetHostInterfaces(){
    	$interfaces = Vbox::getHostInterfaces();
    	return $interfaces;
    }


    public function apiGetBridgeAdapter($name){
    	$info = Vbox::getBridgeAdapter($name);
    	return $info;
    }

    public function apiSetNetworkInterface(Request $request, $name){
        $request->validate([
            'vm-network-mode' => ['required', Rule::in(['NAT', 'Bridged'])],
        ]);


        $mode = $request->input('vm-network-mode');
        
        Vbox::setNICMode($name, strtolower($mode));

        sleep(5);

        if(strpos(Vbox::getNetworkInterface($name, 'NIC 1'), $mode)){
            return response()->json(['message'=>'NIC 1 Changed to '.$mode], 200);
        }else{
            return response()->json(['message'=>'NIC 1 Unchanged'], 500);
        }
    }

    public function apiSetBridgedAdapter(Request $request, $name){
        $request->validate([
            'vm-bridged-adapter' => ['required', Rule::in(Vbox::getHostInterfaces())],
        ]);

        $device = $request->input('vm-bridged-adapter');

        if(strpos(Vbox::getNetworkInterface($name, 'NIC 1'), 'Bridged')){
            Vbox::setBridgedAdapter(strtolower($name), $device);

            sleep(5);

            if(strpos(Vbox::getNetworkInterface($name, 'NIC 1'), $device)){
                return response()->json(['message'=>'Bridge Adapter Changed to '.$device], 200);
            }else{
                return response()->json(['message'=>'Bridge Adapter not changed.'], 500);
            }
        }
        return response()->json(["message" => "VM must be set to bridged to call this method"], 500);
        
    }

    public function apiReset($name){
        $ip = VM::find($name)['ip'];
        if(Vbox::isRunning($ip)){
            Vbox::reset($name);

            sleep(30);
            if(!Vbox::isRunning($ip)){
                $vm->status = True;
                $vm->save();
                return response()->json_decode(['message' => 'Machine successfully reset'], 200);
            }else{
                $vm->status = False;
                $vm->save();
                return response()->json_decode(['message' => 'Machine is did not reset'], 500);
            }

        }else{
            return response()->json(['message' => 'Cannot reset, Machine is not powered on'], 500);
        }
        
    }

    public function apiPower($name){
        $vm = VM::find($name);
        $ip = $vm['ip'];

        if(Vbox::isRunning($ip)){
            Vbox::powerOff($name);
            sleep(5);
            if(Vbox::isRunning($ip)){
                $vm->status = False;
                $vm->save();
                return response()->json_decode(['message' => 'Machine successfully powered off'], 200);
            }else{
                $vm->status = True;
                $vm->save();
                return response()->json_decode(['message' => 'Machine is not off'], 500);
            }
        }else{
            Vbox::powerOn($name);
            sleep(30);
            if(!Vbox::isRunning($ip)){
                $vm->status = True;
                $vm->save();
                return response()->json_decode(['message' => 'Machine successfully powered on'], 200);
            }else{
                $vm->status = False;
                $vm->save();
                return response()->json_decode(['message' => 'Machine is not powered on'], 500);
            }
        }
    }
}
