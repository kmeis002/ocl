<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrolled extends Model
{
   	protected $table = 'enrolled';
	protected $primaryKey = 'id';


	protected $fillable = [
		'student', 'class_id',
	];
}
