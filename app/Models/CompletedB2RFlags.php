<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompletedB2RFlags extends Model
{
    //Setup table information
	protected $table = 'b2r_flags_completed';
	protected $primaryKey = 'student';
	protected $keyType = 'string';

	//Mass fillable arrays
	protected $fillable = [
		'student', 'b2r_name', 'is_root',
	];

}