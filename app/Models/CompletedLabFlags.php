<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Labs;

class CompletedLabFlags extends Model
{
    //Setup table information
	protected $table = 'lab_flags_completed';

	//Mass fillable arrays
	protected $fillable = [
		'student', 'lab_name', 'level',
	];

	public function machine(){
		return $this->belongsTo('App\Models\VM', 'lab_name', 'name');
	}

	public function basePoints(){
		return $this->machine()->get()[0]->points;
	}

	public function levels(){
		return Labs::find($this->machine()->get()[0]->name)->countLevels();
	}


	public static function boot() {
        parent::boot();

        //Modify score history when flag is completed & rotate flag
        self::created( function($CompletedLabFlags) {

        	$studentName = $CompletedLabFlags->student;

        	$description = 'Level '.$CompletedLabFlags->level.' for '.$CompletedLabFlags->lab_name.'.';

        	//Create Score 
        	Score::create([
        		'student' => $studentName,
        		'points' => Score::labFlagToScore($CompletedLabFlags),
        		'description' => $description,
        	]);

        	//Rotate Flag
        	$vm = VM::find($CompletedLabFlags->lab_name);
       		$vm->changeFlag($CompletedLabFlags->level);
        });

    }


}
