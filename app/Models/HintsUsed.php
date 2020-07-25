<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

use App\Models\Score;
use App\Models\Student;

class HintsUsed extends Model
{
    protected $table = 'hints_used';


	protected $fillable = [
		'student', 'hint_id', 'machine_name',
	];

    public static function boot() {
        parent::boot();
        static::created(function($HintsUsed) { 
            //Get Student raw score and add new score

        	Storage::put('/tmp/hinttest.txt', $HintsUsed);
            $s = Student::where('name', '=', $HintsUsed['student'])->get()[0];
            Score::updateStudentScore($s);
        });
    }
}
