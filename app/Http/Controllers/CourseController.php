<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courses;

/*
|--------------------------------------------------------------------------
| Courses Controller
|--------------------------------------------------------------------------
|
| CRUD for Courses.
|
| To-Do:
| - Endpoints (will work when Frontend begins)
|
|
*/


class CourseController extends Controller
{

	public function create(Request $request){

	}
    
    public function store(Request $request){
    	$request->validate([
    		'name' => 'required']);

    	Courses::create([
    		'name' => $request->input('name'),
    	]);
    }

    public function update(Request $request){
    	$request->validate([
    		'name' = > 'required']);

    	$course = Courses::find($request->input('name'));

    	$course->name = $request->input('name');
    	$course->save();
    }

    public function destroy($name){
    	$course = Courses::find($name);
    	$course->delete();
    }

}
