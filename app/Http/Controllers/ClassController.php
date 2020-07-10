<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Classes;



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


class ClassController extends Controller
{

	public function apiCreate(Request $request){
        $request->validate([
            'course' => 'required',
            'teacher' => 'required',
            'bell' => ['required', 'numeric', 'min:0'],
        ]);

        Classes::create([
            'course' => $request->input('course'),
            'teacher' => $request->input('teacher'),
            'bell' => $request->input('bell'),
        ]);
	}
    


    public function apiDestroy($id){
    	$class = Classes::find($id);
    	$class->delete();
    }

    public function apiGetClasses(){
        return DB::table('classes')->select('id', 'course', 'bell')->get();
    }

}
