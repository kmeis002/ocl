<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VMSkills extends Model
{
    //Setup table information
	protected $table = 'vm_skills';

	//Mass fillable arrays
	protected $fillable = [
		'vm_name', 'skill',
	];
}
