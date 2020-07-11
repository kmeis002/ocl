<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CtfsAssigned extends Model
{
    //Setup table information
	protected $table = 'ctfs_assigned';

	//Mass fillable arrays
	protected $fillable = [
		'assignment_id', 'ctf_name',
	];
}
