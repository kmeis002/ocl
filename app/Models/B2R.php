<?php

namespace App\Models;

use Illuminate\Database\EloApp\quent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


use App\Models\VM;
use App\Models\B2RFlags;

/*
|--------------------------------------------------------------------------
| B2R Model
|--------------------------------------------------------------------------
|
| B2R Model extends VM. 
|
|
*/


class B2R extends VM
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
			$query->select('b2r_name')->from('b2r_flags');
		})->get();
	}

	//overrides create() function, makes a VM + Flags
	public static function create($data){
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
        if($data['user-flag'] !== null && $data['manual-flags'] === 'Manual'){
            B2RFlags::create([
                'b2r_name' => $data['vm-name'],
                'user_flag' => $data['user-flag'],
                'root_flag' => $data['root-flag'],
            ]);
        }else{
            B2RFlags::create([
                'b2r_name' => $data['vm-name'],
                'user_flag' => md5(Str::random(config('flag_random'))),
                'root_flag' => md5(Str::random(config('flag_random'))),
            ]);
        }
	}

	public function flags(){
		return $this->hasOne('App\Models\B2RFlags', 'b2r_name', 'name');
	}

	public function hints(){
		return $this->hasMany('App\Models\B2RHints', 'b2r_name', 'name');
	}

	public function skills(){
		return $this->hasMany('App\Models\VMSkills', 'vm_name', 'name');
	}


}
