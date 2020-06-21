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


class Hints extends Model
{
    
	//Setup table information
	protected $table = 'hints';
	protected $primaryKey = 'id';

	//Mass fillable arrays
	protected $fillable = [
		'vm_name', 'hint',
	];

}
