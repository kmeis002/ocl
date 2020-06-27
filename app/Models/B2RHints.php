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


class B2RHints extends Model
{
    
	//Setup table information
	protected $table = 'b2r_hints';
	protected $primaryKey = 'id';

	//Mass fillable arrays
	protected $fillable = [
		'b2r_name', 'hint', 'is_root',
	];

}
