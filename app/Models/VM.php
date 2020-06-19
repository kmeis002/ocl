<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Models\B2RFlags;
use App\Models\LabFlags;
use App\Models\Mqtt;

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
| - getAllFlag()
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


	public static function deleteFlags(){
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
			Storage::delete('vm/'.$this->name.'.ova');
			$this->delete();
		}
	}


	//$flag is either root_flag, boot_flag, or level 1-n
	public function changeFlag($flag_id){
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

			return 'Lab Level does not exist';
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

	}

	public function checkFlag($flag_id, $submitted){
		return ($this->getFlag($flag_id) == $submitted);
	}

	public function countLevels(){
		return LabFlags::where('lab_name', $this->name)->count();
	}


	public function isB2R(){
		return B2RFlags::where('b2r_name', $this->name)->exists();
	}

	public function isLab(){
		return LabFlags::where('lab_name', $this->name)->exists();
	}
}

