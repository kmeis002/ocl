<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courses;

/*
|--------------------------------------------------------------------------
| Class Controller
|--------------------------------------------------------------------------
|
| CRUD for classes.
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
    		'course' => 'required',
            'bell' => 'required|numeric',
            'teacher' => 'required',
        ]);

    	Classes::create([
    		'course' => $request->input('vm_name'),
    		'bell'	=> $request->input('hint'),
            'teacher' => $request->input('teacher')
    	]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'course' => 'required',
            'bell' => 'required|numeric',
            'teacher' => 'required',
        ]);

    	$class = Courses::find($id);

    	$class->course = $request->input('course');
        $class->bell = $request->input('bell');
        $class->teacher = $request->input('teacher');
    	$class->save();
    }

    public function destroy($id){
    	$class = Courses::find($id);
    	$hint->delete();
    }

}
