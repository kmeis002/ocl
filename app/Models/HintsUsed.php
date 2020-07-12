<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HintsUsed extends Model
{
    protected $table = 'hints_used';
	protected $primaryKey = 'student';
	protected $keyType = 'string';


	protected $fillable = [
		'student', 'hint_id', 'machine_name',
	];
}
