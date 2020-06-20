<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Exceptions\GenericVMException;

use App\Models\B2RFlags;
use App\Models\LabFlags;
use App\Models\Mqtt;

use Vbox;

/*
|--------------------------------------------------------------------------
| VM Model
|--------------------------------------------------------------------------
|
| Class for VMs which make up the Boot2Root and Lab classes. Controller checks
| $request field to determine which type and appropriate create() functions
| are called to populate tables.
| 
| To Do:
|	- Verification will be handled with AJAX. User can reissue commands if they do not work.
|
*/

class VM extends Model
{

	//Setup table information
	protected $table = 'vms';
	protected $primaryKey = 'name';
	protected $keyType = 'string';

	//Mass fillable arrays
	protected $fillable = [
		'name', 'points', 'os', 'file', 'icon', 'description', 'ip', 'status',
	];



	//Create Boot2Root machine (Creates flags in B2R_Flags as well)
	public static function createB2R($data){
		VM::create([
            'name' => $data['name'],
            'points' => $data['points'],
            'os' => $data['os'],
            'ip' =>  $data['ip'],
            'file' =>'Placeholder',
            'status' => False,
            'icon' => $data['icon'],
            'description' => $data['description'],            
        ]);

        #create b2rflags with linked vm name
        B2RFlags::create([
        	'b2r_name' => $data['name'],
        	'user_flag' => md5(Str::random(config('flag.random'))),        	
        	'root_flag' => md5(Str::random(config('flag.random'))),
        ]);
	}

	//Create Lab machine (Creates flags in Lab_Flags as well)
	public static function createLab($data){
		VM::create([
            'name' => $data['name'],
            'points' => $data['points'],
            'os' => $data['os'],
            'ip' =>  $data['ip'],
            'file' =>'Placeholder',
            'status' => False,
            'icon' => $data['icon'],
            'description' => $data['description'],            
        ]);

		#Seed level flags
		for($i = 1; $i <= $data['levels']; $i++){
	        LabFlags::create([
	        	'lab_name' => $data['name'],
	        	'level' => $i,
	        	'flag' => md5(Str::random(config('flag_random'))),
	        ]);
	    }
	}


	public function destroyVM(){
		if($this->isB2R()){
			$flags = B2RFlags::find($this->name);
			$flags->delete();
			Storage::delete('vm/'.$this->name.'.ova');
			$this->delete();
		}

		if($this->isLab()){
			$flags = LabFlags::where([
				'lab_name' => $this->name]) -> get();

			foreach (flags as $flag){
				$flag->delete();
			}
			//Storage::delete('vm/'.$this->name.'.ova');
			$this->delete();
		}
	}


	//$flag is either root_flag, boot_flag, or level 1-n
	public function changeFlag($flag_id){
		if($this->status){
			$mqtt = new Mqtt();
			if($this->isB2R()){
				$flags = B2RFlags::find($this->name);
	    		$newflag = md5(Str::random(config('flag.random')));
	    		$flags->$flag_id = $newflag;
	    		$flags->save();
	    		return $mqtt->publish($this->name.'/'.$flag_id, $newflag);
			}

			if($this->isLab()){
				if($flag_id <= $this->countLevels()){
					$lvl = LabFlags::where([
						'lab_name' => $this->name,
						'level'    => $flag_id])->get()[0];
					$newflag = md5(Str::random(config('flag.random')));
					$lvl->flag = $newflag;
					$lvl->save();
					return $mqtt->publish($this->name.'/level'.$flag_id, $newflag);
				}

				throw new GenericVMException('Lab Level exceeds maximum level of '. $this->name);
			}
		}
		throw new GenericVMException('VM '. $this->name .' must be powered on');
	}

	public function changeAllFlags(){
		if($this->isB2R()){
			$this->changeFlag('user_flag');
			$this->changeFlag('root_flag');
		}

		if($this->isLab()){
			for($i=1; $i<=$this->countLevels(); $i++){
				$this->changeFlag($i);
			}
		}
	}

	public function changeStatus(){
		if(Vbox::isRunning($this->ip)){
			$this->status=true;
			$this->save();
		}else{
			$this->status=false;
			$this->save();
		}
	}
	//Returns a specific flag_id, must be root_flag, user_flag, user lvl 
	public function getFlag($flag_id){
		if($this->isB2R()){
			return B2RFlags::find($this->name)->$flag_id;
		}

		if($this->isLab()){
			return LabFlags::where([
				'lab_name' => $this->name,
				'level' => $flag_id])->get()[0]->flag;
		}

		throw new GenericVMException('Flag '.$flag_id.' not found.');
	}

	//Returns all flags associated with $vm object
	public function getAllFlags(){
		if($this->isB2R()){
			return B2RFlags::find($this->name);
		}
		if($this->isLab()){
			return LabFlags::where('lab_name', $this->name)->get();
		}
	}

	public function checkFlag($flag_id, $submitted){
		return ($this->getFlag($flag_id) == $submitted);
	}

	public function countLevels(){
		if(!$this->isLab()){
			throw new GenericVMException($this->name.' is not a Lab.');
		}
		return LabFlags::where('lab_name', $this->name)->count();
	}


	public function isB2R(){
		return B2RFlags::where('b2r_name', $this->name)->exists();
	}

	public function isLab(){
		return LabFlags::where('lab_name', $this->name)->exists();
	}


	//Loads the vm .ova (must be uploaded up)
	public function loadVM(){
    	if(!Storage::exists('/vm/'.$this->name.'.ova')){
    		throw new GenericVMException($this->name.'.ova was not found.');
    	}

    	//Verify its not already registered
    	if(Vbox::isRegistered($this->name)){
    		throw new GenericVMException($this->name.' is already registered.');
    	}
    	
    	$mqtt = new Mqtt();
    	$mqtt->publish('vm/import', $this->name);

	}

	public function unregisterVM(){
		//Verify machine is registered
    	if(!Vbox::isRegistered($this->name)){
    		throw new GenericVMException($this->name.' is not registered.');
    	}

    	//Verify its not already registered
    	if(Vbox::isRegistered($this->name)){
    		throw new GenericVMException($this->name.' is already registered.');
    	}

    	$mqtt = new Mqtt();
    	$mqtt->publish('vm/unregister', $this->name);

	}

	public function turnOn(){
		if(Vbox::isRunning($this->ip)){
			throw new GenericVMException($this->name.' is already active.');
		}

    	if(!Vbox::isRegistered($this->name)){
    		throw new GenericVMException($this->name.' is not yet registered.');
    	}

		$mqtt = new Mqtt();
		$mqtt->publish('vm/start', $this->name);

		//Change this to a better method for status verification.
		sleep(40);

		$this->changeStatus();
	}

	public function reset(){
		if(!Vbox::isRunning($this->ip)){
			throw new GenericVMException($this->name.' is powered off.');
		}

    	if(!Vbox::isRegistered($this->name)){
    		throw new GenericVMException($this->name.' is not yet registered.');
    	}

		$mqtt = new Mqtt();
		$mqtt->publish('vm/reset', $this->name);

		//Change this to a better method for status verification.
		sleep(40);

		$this->changeStatus();

	}

	public function turnOff(){
		if(!Vbox::isRunning($this->ip)){
			throw new GenericVMException($this->name.' is already powered off.');
		}

    	if(!Vbox::isRegistered($this->name)){
    		throw new GenericVMException($this->name.' is not yet registered.');
    	}

		$mqtt = new Mqtt();
		$mqtt->publish('vm/stop', $this->name);

		sleep(3);

		$this->changeStatus();
	}

	//only NAT, Bridged supported (to support intnet soon)
	public function modifyNetworkType($type){
    	if(!Vbox::isRegistered($this->name)){
    		throw new GenericVMException($this->name.' is not yet registered.');
    	}

		if(Vbox::isRunning($this->ip)){
			throw new GenericVMException($this->name.' must be powered off to change networking type.');
		}
	}

}

