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

class LabFlags extends Model
{

	//Setup table information
	protected $table = 'lab_flags';
	protected $primaryKey = 'id';

	//Mass fillable arrays
	protected $fillable = [
		'lab_name', 'level', 'flag'
	];

	


}

