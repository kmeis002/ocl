<?php

namespace App\Models;

use Illuminate\Database\EloApp\quent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use App\Models\VM;
use App\Models\LabFlags;

use Vbox;

/*
|--------------------------------------------------------------------------
| Lab Model
|--------------------------------------------------------------------------
|
| Lab Model extends VM. 
|
|
*/


class Labs extends VM
{
	//Setup table information
	protected $table = 'vms';
	protected $primaryKey = 'name';
	protected $keyType = 'string';

	//Mass fillable arrays
	protected $fillable = [
		'name', 'points', 'os', 'file', 'icon', 'description', 'ip', 'status',
	];


	//overrides all, returns only VMs that have flags in b2r_flags
	public static function all($columns = ['*']){
		return DB::table('vms')->select('*')->whereIn('name', function($query){
			$query->select('lab_name')->from('lab_flags');
		})->get();
	}

	//overrides create() function, makes a VM + Flags
	public static function create($data){

		$levelCount = $data['level-count']; 
        VM::create([
            'name' => $data['vm-name'],
            'points' => $data['pts'],
            'ip' => $data['ip'],
            'icon' => $data['icon'],
            'os' => $data['os-select'],
            'status' => false,
            'description' => $data['description'],
        ]);

        //Populate manual flags, otherwise put placeholders to announce to mqtt when file is uploaded
        if($data['manual-flags'] === 'Manual'){
	        for($i=1; $i<=$levelCount; $i++){
	            LabFlags::create([
	            	'lab_name' => $data['vm-name'],
	            	'level' => $i,
	            	'flag' => $data['level-flag-'.$i],
	            ]);
	        }
        }else{
        	for($i=1; $i<=$levelCount; $i++){
	            LabFlags::create([
	            	'lab_name' => $data['vm-name'],
	            	'level' => $i,
	            	'flag' => md5(Str::random(config('flag_random'))),
	            ]);
	        }
        }
	}

	public function flags(){
		return $this->hasMany('App\Models\LabFlags', 'lab_name', 'name')->orderBy('level', 'asc');
	}

	public function hints(){
		return $this->hasMany('App\Models\LabHints', 'lab_name', 'name')->orderBy('level', 'asc');
	}

	public function skills(){
		return $this->hasMany('App\Models\VMSkills', 'vm_name', 'name');
	}

    public function getHints(){
        $hintInfo = DB::table('lab_hints')->select('id', 'level')->where([
            ['lab_name', '=', $this->name],
        ])->get();
        return $hintInfo;
    }

    public function countLevels(){
    	return DB::table('lab_flags')->where(['lab_name' => $this->name])->count();
    }

	//Events
	public static function boot() {
        parent::boot();

        //Delete event to delete entries in other tables/files
        static::deleting(function($Labs) { 
        	//Delete hasMany relations
             $Labs->flags()->delete();
             $Labs->hints()->delete();
             $Labs->skills()->delete();

            //Delete associated files

            $path = storage_path('app').'/vm/';
			$vmName = explode('.',$Labs->file)[0];

            if($Labs->file !== null && File::exists($path.$Labs->file)){
             	File::delete($path.$Labs->file);

             }


            //Unregister VM if it exists
            if($vmName !== ""){
	            if(Vbox::isRegistered($vmName)){
	            	if(Vbox::isRunning($vmName)){
	            		Vbox::powerOff($vmName);
	            	}
	            	sleep(1);
	            	Vbox::unregister($vmName);
	            }
        	}
        });
    }
}
