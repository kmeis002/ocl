<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabsAssigned extends Model
{
    //Setup table information
	protected $table = 'labs_assigned';

	//Mass fillable arrays
	protected $fillable = [
		'assignment_id', 'lab_name', 'start_level', 'end_level',
	];

}
