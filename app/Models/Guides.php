<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guides extends Model
{
    //Setup table information
	protected $table = 'guides';

	//Mass fillable arrays
	protected $fillable = [
		'name', 
	];
}
