<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skills extends Model
{
    //Setup table information
	protected $table = 'skills';


	//Mass fillable arrays
	protected $fillable = [
		'skill',
	];
}
