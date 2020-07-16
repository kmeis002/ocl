<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompletedCtfs extends Model
{
    //Setup table information
	protected $table = 'ctfs_completed';

	//Mass fillable arrays
	protected $fillable = [
		'student', 'ctf_name',
	];

	public function machine(){
		return $this->belongsTo('App\Models\Ctfs', 'ctf_name', 'name');
	}

	public function basePoints(){
		return $this->machine()->get()[0]->points;
	}


	public static function boot() {
        parent::boot();

        //Modify score history when flag is completed & rotate flag
        self::created( function($CompletedCtfs) {

        	$studentName = $CompletedCtfs->student;

        	$description = 'Captured the '.$CompletedCtfs->ctf_name.' flag.';

        	//Create Score 
        	Score::create([
        		'student' => $studentName,
        		'points' => Score::ctfFlagToScore($CompletedCtfs),
        		'description' => $description,
        	]);
        });

    }

}
