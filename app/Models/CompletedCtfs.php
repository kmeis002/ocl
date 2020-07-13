<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompletedCtfs extends Model
{
    //Setup table information
	protected $table = 'ctfs_completed';
	protected $primaryKey = 'student';
	protected $keyType = 'string';

	//Mass fillable arrays
	protected $fillable = [
		'student', 'ctf_name',
	];
}
