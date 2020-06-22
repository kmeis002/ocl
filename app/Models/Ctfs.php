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


class Ctfs extends Model
{
    
	//Setup table information
	protected $table = 'ctfs';
	protected $primaryKey = 'name';

	//Mass fillable arrays
	protected $fillable = [
		'name', 'points', 'file', 'description', 'flag',
	];

}
