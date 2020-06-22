<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\B2RFlags;
use App\Models\LabFlags;
use App\Models\Ctfs;

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

	public function calculateTotalScore(){
		$ctfs = Ctfs::all()->count();
		$b2rs = B2RFlags::all()->count();
		$labs = DB::table($this->table)->select('lab_name')->distinct()->count();

		$b2r_score = config('score.user_weight')
	}
}

