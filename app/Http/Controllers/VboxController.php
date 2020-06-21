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

  	public function poll(Request $request){

  	}

}
