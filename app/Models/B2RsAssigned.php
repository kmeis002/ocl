<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class B2RsAssigned extends Model
{
    //Setup table information
	protected $table = 'b2rs_assigned';

	//Mass fillable arrays
	protected $fillable = [
		'assignment_id', 'b2r_name', 'user', 'root',
	];
}
