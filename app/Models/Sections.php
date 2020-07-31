<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    //Setup table information
	protected $table = 'reference_sections';


	//Mass fillable arrays
	protected $fillable = [
		'name', 'content', 'references_id',
	];

}
