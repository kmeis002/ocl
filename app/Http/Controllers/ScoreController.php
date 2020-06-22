<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Score;

/*
|--------------------------------------------------------------------------
| Score Controller
|--------------------------------------------------------------------------
|
| CRUD for Scores (To be used by FlagController).
|
| To-Do:
| - Endpoints (will work when Frontend begins)
|
|
*/



class ScoreController extends Controller
{
   	public function create(Request $request){

	}
    
    public function store($data){
    	Score::create([
    		'student' => $data['student'],
    		'points' => $data['points'],
    		'description' => $data['description'],
    	]);
    }

    public function update($data, $id){

    	$score = Score::find($id);

    	$score->points = $data['points'];
    	$score->description = $data['description'];
    }

    public function destroy($id){
    	$score = Score::find($id);
    	$score->delete();
    }
}
