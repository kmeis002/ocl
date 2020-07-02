<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

use App\Exceptions\GenericVMException;

use App\Models\B2RFlags;
use App\Models\LabFlags;
use App\Models\Hints;
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
|	- Full Unit Testing
| 	- Consider new ways of testing verification of vbox controls
|   - Deletion of flags/hints/ova files.
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

		$hints = Hints::where(['vm_name' => $this->name]);
		
		foreach (hints as $hint){
			$hint->delete();
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

	public static function allLabs(){
		return DB::table('vms')->select('*')->whereIn('name', function($query){
			$query->select('lab_name')->from('lab_flags');
		})->get();
	}

	public static function allB2R(){
		return DB::table('vms')->select('*')->whereIn('name', function($query){
			$query->select('b2r_name')->from('b2r_flags');
		})->get();
	}

	public function hints(){
		if($this->isB2R()){
			return $this->hasMany('App\Models\B2RHints', 'b2r_name', 'name');
		}
		if($this->isLab()){
			return $this->hasMany('App\Models\LabHints', 'lab_name', 'name');
		}
	}

	public function flags(){
		if($this->isB2R()){
			return $this->hasOne('App\Models\B2RFlags', 'b2r_name', 'name');
		}

		if($this->isLab()){
			return $this->hasMany('App\Models\LabFlags', 'lab_name', 'name');
		}
	}

	public function skills(){
		return $this->hasMany('App\Models\VMSkills', 'vm_name', 'name');
	}

	//Need to FIX THIS WITH ELOQUENT CHANGES!!!
	public function checkFlag($flag_id, $submitted){
		return ($this->getFlag($flag_id) == $submitted);
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
    	if(Vbox::isRunning($this->ip)){
    		throw new GenericVMException($this->name.' must be powered off.');
    	}

    	$mqtt = new Mqtt();
    	$mqtt->publish('vm/unregister', $this->name);

    	if(Vbox::isRegistered($this->name)){
    		throw new GenericVMException($this->name.' is still registered.');
    	}

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

		$mqtt = new Mqtt();
    	$mqtt->publish('vm/modifyNIC', $this->name.','.$type);

    	sleep(3);

    	if(!strpos(strtolower(Vbox::getNetworkInterface($this->name, 'NIC 1')), strtolower($type))){
    		throw new GenericVMException('Network type did not change');
    	}
	}

	//Changes bridged adapter.
	public function modifyBridgeAdapter($adapter){
    	if(!Vbox::isRegistered($this->name)){
    		throw new GenericVMException($this->name.' is not yet registered.');
    	}

		if(Vbox::isRunning($this->ip)){
			throw new GenericVMException($this->name.' must be powered off to change networking type.');
		}

		if(!in_array($adapter, Vbox::getHostInterfaces())){
			throw new GenericVMException($adapter.' is not a valid host interface.');
		}

		$mqtt = new Mqtt();
    	$mqtt->publish('vm/modifyBridged', $this->name.','.$adapter);

    	sleep(3);

    	if(!strpos(strtolower(Vbox::getNetworkInterface($this->name, 'NIC 1')), strtolower($adapter))){
    		throw new GenericVMException('Adapter did not change.');
    	}
	}

}

