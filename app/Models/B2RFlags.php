<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| VM Model
|--------------------------------------------------------------------------
|
| Class for VMs which make up the Boot2Root and Lab classes. 
| 
|
*/

class B2RFlags extends Model
{

	//Setup table information
	protected $table = 'b2r_flags';
	protected $primaryKey = 'b2r_name';
	protected $keyType = 'string';

	//Mass fillable arrays
	protected $fillable = [
		'b2r_name', 'user_flag', 'root_flag'
	];



	//getter functions for VM
	public function getAttr(){
		return $this->fillable;
	}


}

