<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Student;
use App\Models\Labs;
use App\Models\B2R;
use App\Models\Ctfs;

class StudentController extends Controller
{

	public function __construct(){

        $this->middleware('auth:student');

    }


    public function show(){

    	return view('student.home');

    }


    public function listResources($type){
        if($type === 'lab'){
            $list = Labs::all();
        }
        if($type === 'b2r'){
            $list = B2R::all();
        }
        if($type === 'ctf'){
            $list = Ctfs::all();
            $categories = DB::table('ctfs')->select('category')->distinct()->get();
        }

        if($type === 'lab' || $type === 'b2r'){
            return view('student.resources.list')->with(['list'=>$list, 'type' => $type]);
        }else if($type === 'ctf'){
            return view('student.resources.list')->with(['list'=>$list, 'type' => $type, 'categories' => $categories]);
        }
    }

}
