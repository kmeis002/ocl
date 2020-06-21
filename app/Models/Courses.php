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


class Courses extends Model
{
    
	//Setup table information
	protected $table = 'courses';
	protected $primaryKey = 'name';

	//Mass fillable arrays
	protected $fillable = [
		'name',
	];

}