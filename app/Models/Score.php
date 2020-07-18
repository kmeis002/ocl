<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\B2R;
use App\Models\Labs;
use App\Models\Student;
use App\Models\Ctfs;
use App\Models\HintsUsed;

/*
|--------------------------------------------------------------------------
| Score Model
|--------------------------------------------------------------------------
|
| Model for individual scores (for tracking individual stats and user timeline)
| 
|
*/

class Score extends Model
{

	//Setup table information
	protected $table = 'score';


	//Mass fillable arrays
	protected $fillable = [
		'student', 'points', 'description'
	];

	//Calculates total possible points from B2R Machines
	public static function totalB2R(){
		$b2rCollection = B2R::all();
		$scoreTotal = 0;
		foreach ($b2rCollection as $b2r) {
			$scoreTotal = $scoreTotal + (config('score.user_weight') + config('score.root_weight'))*($b2r->points);
		}

		$scoreTotal = $scoreTotal*config('score.b2r_weight');

		return $scoreTotal;
	}

	//Calculates total possible points from Lab Machines
	public static function totalLab(){
		$labCollection = Labs::all();
		$scoreTotal = 0;

		foreach($labCollection as $lab){
			$scoreTotal = $scoreTotal + $lab->points;
		}

		$scoreTotal = config('score.lab_weight')*$scoreTotal;

		return $scoreTotal;
	}

	//Calculates total possible points from Capture the Flags
	public static function totalCtf(){
		$ctfCollection = Ctfs::all();
		$scoreTotal = 0;

		foreach($ctfCollection as $ctf){
			$scoreTotal = $scoreTotal + $ctf->points;
		}

		$scoreTotal = config('score.ctf_weight')*$scoreTotal;

		return $scoreTotal;

	}

	//Total possible score for progress bar
	public static function totalScore(){
		return Score::totalCtf() + Score::totalLab() + Score::totalB2R();
	}

	//Calculates student raw score (no hint deductions) to be added to student model
	public static function studentRawScore($name){
		$rawScore =0;
		$scoreHistory = Score::where(['student', '=', $name])->get();

		foreach($scoreHistory as $score){
			$rawScore = $rawScore + $score->points;
		}

		return $rawScore;

	}

	//returns RawScore - Hints
	public static function calculateModifier($name){
		$hintsUsed = HintsUsed::where('student', '=', $name)->count();

		return config('score.hint_points')*$hintsUsed;
	}

	public static function b2rFlagToScore($flag){
		$points = $flag->basePoints();

		if($flag->is_root){
			return config('score.b2r_weight')*(config('score.root_weight')*$points);
		}else{
			return config('score.b2r_weight')*(config('score.user_weight')*$points);
		}
	}

	public static function labFlagToScore($flag){
		$points = $flag->basePoints();
		$levels = $flag->levels();

		return (config('score.lab_weight')*pow($points/$levels, config('score.level_weight')));
	}

	public static function ctfFlagToScore($flag){
		return config('score.ctf_weight')*$flag->basePoints();
	}

    public static function boot() {
        parent::boot();

        //Delete event to delete entries in other tables/files
        static::created(function($score) { 
            //Get Student raw score and add new score
            $s = Student::where('name', '=', $score->student)->get()[0];

            $raw = $s->raw_score;
            $raw = $raw + $score->points;
            $s->raw_score = $raw; 
            $mod = $raw - Score::calculateModifier($s->name);
            $s->mod_score = $mod;
            $s->save();
        });
    }

}

