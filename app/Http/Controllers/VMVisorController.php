<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use App\Models\VM;
use Mqtt;

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
| - Implement other hypervisors
| - LoadVM is REAL janky, fix with a more secure/resilient solution
*/


class VMVisorController extends Controller
{
    //Loads VM into virtualbox
    public function loadVM(Request $request){

    	//$name = VM::find($request->input['name']);
    	$filename = $request->input('name').'.ova';
    	//verify VM ova exists
    	if(!Storage::exists('/vm/'.$filename)){
    		return response()->json(['message'=>'OVA File '.$filename.' Not Found'], 500);
    	}

    	//Verify its not already registered
    	if($this->exists($request->input('name'))){
    		return response()->json(['message'=>'Virtual Machine with the same name already registered'],500);
    	}

    	set_time_limit(0);
    	//Import OVA File, can take a while. AJAX call will poll later to determine if it exists
    	$this->vboxImportOVA($filename);
  	}

  	public function poll(Request $request){
  		//Check error states
  		if(!Storage::exists('/vm/'.$request->input('name').'.ova')){
  			return response()->json(['error'=>$request->input('name').'.ova Not Found, try reuploading image'], 500);
  		}
  		if(!$this->exists($request->input('name'))){
  			return response()->json(['error'=>$request->input('name').' not found, try reimporting'], 500);
  		}

  		return response()->json(['vm'=>$request->input('name'),'status'=>'to be implemented'], 200);

  	}

  	private function vboxImportOVA($ovaFile){
  		$process = new Process(['vboxmanage', 'import', Storage::path('/vm/'.$ovaFile)]);
  		$process->run();

  		return $process->isSuccessful();
  	}

  	//Calls vboxmanage $cmd and returns output
  	private function vboxGetAllVM(){
  		$process = new Process(['vboxmanage', 'list', 'vms']);

  		$process->run();

  		return $process->getOutput();
  		
  	}

  	//Return specific VM by name
  	private function vboxGetVM($name){
  		$process = new Process(['vboxmanage', 'list', 'vms']);
  		$process->run();
  		$data = $process->getOutput();
  		if(!strpos($data, $name)){
  			return false;
  		}

  		$data = explode(PHP_EOL, $data);


  		foreach($data as $machine){
  			if(is_int(strpos($machine, $name))){
  				return $machine;
  			}
  		}
  	}



  	public function exists($vm){
  		return is_string($this->vboxGetVM($vm));
  	}

  	//Helper functions for VM names and ids
  	private function getName($vm){
  		return trim(explode('{', $vm)[0],'\" ');
  	}

  	private function getId($vm){
  		return trim(explode('{', $vm)[1], '\" {}');
  	}

  	public function MqttTest(Request $request){
        $message = $request->input('message');
        $topic = "VM";

        if(Mqtt::ConnectAndPublish($topic, $message)){
            return response()->json(['message' => 'MQTT Message Published'], 200);
        }

        return response()->json(['error' => 'MQTT Message could not be published'], 500);
        
    }
}
