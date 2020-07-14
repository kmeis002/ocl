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
				if($flag_id <= LabFlags::where('lab_name', '=', $this->name)->count()){
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


	public function skills(){
		return $this->hasMany('App\Models\VMSkills', 'vm_name', 'name');
	}




	public function isB2R(){
		return B2RFlags::where('b2r_name', $this->name)->exists();
	}

	public function isLab(){
		return LabFlags::where('lab_name', $this->name)->exists();
	}

}

