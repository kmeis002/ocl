<?php

namespace App\Models;

use Illuminate\Database\EloApp\quent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\VM;
use App\Models\LabFlags;

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
	protected $keyType = 'string';

	//Mass fillable arrays
	protected $fillable = [
		'name', 'points', 'file', 'description', 'category', 'icon', 'flag',
	];


}
