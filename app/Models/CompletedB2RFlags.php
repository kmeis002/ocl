<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

use App\Models\Score;

class CompletedB2RFlags extends Model
{
    //Setup table information
	protected $table = 'b2r_flags_completed';

	//Mass fillable arrays
	protected $fillable = [
		'student', 'b2r_name', 'is_root',
	];

	public function machine(){
		return $this->belongsTo('App\Models\VM', 'b2r_name', 'name');
	}

	public function basePoints(){
		return $this->machine()->get()[0]->points;
	}


	public static function boot() {
        parent::boot();

        //Modify score history when flag is completed & rotate flag
        self::created( function($CompletedB2RFlags) {

        	$studentName = $CompletedB2RFlags->student;

        	if($CompletedB2RFlags->is_root){
        		$description = 'Root Flag for '.$CompletedB2RFlags->b2r_name.'.';
        		$flag = 'root_flag';
        	}else{
        		$description = 'User Flag for '.$CompletedB2RFlags->b2r_name.'.';
        		$flag = 'user_flag';
        	}

        	//Create Score 
        	Score::create([
        		'student' => $studentName,
        		'points' => Score::b2rFlagToScore($CompletedB2RFlags),
        		'description' => $description,
        	]);

        	//Rotate Flag
        	$vm = VM::find($CompletedB2RFlags->b2r_name);
       		$vm->changeFlag($flag);
        });

    }
}