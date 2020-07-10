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

	public function apiCreate(Request $request){
        $request->validate([
            'name' => 'required'
        ]);

        Courses::create([
            'name' => $request->input('name'),
        ]);
	}
    
    public function apiDestroy($name){
        $course = Courses::find($name);
        $course->delete();
    }

    public  function apiGet(){
        return Courses::all();
    }

}
