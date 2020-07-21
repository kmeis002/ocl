<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Skills;

class SkillController extends Controller
{
    public function get(){
    	return Skills::all();
    }

    public function create(Request $request){
    	$request->validate([
    		'skill-name' => ['required', 'string'],
    	]);

    	Skills::create([
    		'name' => $request->input('skill-name'),
    	]);

    	return redirect('/teacher/resources/skills');
    }

    public function delete($id){
    	$skill = Skills::find($id);
    	$skill->delete();
    }

}
