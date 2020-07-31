<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferenceSkills extends Model
{
    //Setup table information
	protected $table = 'reference_skills';

	//Mass fillable arrays
	protected $fillable = [
		'reference_id', 'skill_name',
	];
}
