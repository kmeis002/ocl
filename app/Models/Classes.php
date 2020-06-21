<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| Hints Model
|--------------------------------------------------------------------------
|
| Model for text hints.
|
|
*/


class Classes extends Model
{
    
	//Setup table information
	protected $table = 'classes';
	protected $primaryKey = 'id';

	//Mass fillable arrays
	protected $fillable = [
		'course', 'bell', 'teacher', 
	];

}