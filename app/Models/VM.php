<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Models\B2RFlags;
use App\Models\LabFlags;

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
| - Fix static and organize B2R\Lab models to more accurately reflect models. 
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

	public function isB2R(){
		return B2RFlags::where('b2r_name', $this->name)->exists();
	}

	public function isLab(){
		return LabFlags::where('lab_name', $this->name)->exists();
	}

	//$flag is either root_flag, boot_flag, or level 1-n
	public function changeFlag($flag){
		if($this->isB2R()){
			$flags = B2RFlags::find($this->name);
    		$newflag = md5(Str::random(config('flag.random')));
    		$flags->$flag = $newflag;
    		$flags->save(); 
    		return $newflag;
		}

		if($this->isLab()){
			if($flag <= $this->countLevels()){
				$lvl = LabFlags::where([
					'lab_name' => $this->name,
					'level'    => $flag])->get()[0];
				$newflag = md5(Str::random(config('flag.random')));
				$lvl->flag = $newflag;
				$lvl->save();
				return $newflag;
			}
		}
	}

	public function countLevels(){
		return LabFlags::where('lab_name', $this->name)->count();
	}
}

