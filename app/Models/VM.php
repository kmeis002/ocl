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
|
*/

class VM extends Model
{

	//Setup table information
	protected $table = 'vms';
	protected $primary_key = 'name';
	protected $keyType = 'string';

	//Mass fillable arrays
	protected $fillable = [
		'name', 'points', 'os', 'icon', 'description', 'ip'];


}
