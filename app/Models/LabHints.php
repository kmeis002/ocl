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
|s
*/


class LabHints extends Model
{
    
	//Setup table information
	protected $table = 'lab_hints';
	protected $primaryKey = 'id';

	//Mass fillable arrays
	protected $fillable = [
		'lab_name', 'hint', 'level'
	];

}
