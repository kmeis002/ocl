<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompletedLabFlags extends Model
{
    //Setup table information
	protected $table = 'lab_flags_completed';
	protected $primaryKey = 'student';
	protected $keyType = 'string';

	//Mass fillable arrays
	protected $fillable = [
		'student', 'lab_name', 'level',
	];

}
