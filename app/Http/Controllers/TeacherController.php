<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Models\Labs;
use App\Models\B2R;
use App\Models\Ctfs;
use App\Models\Classes;
use App\Models\Courses;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Enrolled;
use App\Models\Assignments;

class TeacherController extends Controller
{

	public function __construct(){

        //$this->middleware('auth:teacher');

    }


    public function show(){

    	return view('teacher.home');

    }


    public function resourcesList($type){
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
            return view('teacher.resources.list')->with(['list'=>$list, 'type' => $type]);
        }else if($type === 'ctf'){
            return view('teacher.resources.list')->with(['list'=>$list, 'type' => $type, 'categories' => $categories]);
        }
    }


    public function classesList($type){
        if($type === 'course'){
            $courseList = Courses::all();
            $classList = Classes::all();
            return view('teacher.classes.courselist')->with(['courseList'=>$courseList, 'classList'=>$classList, 'type' => $type]);
        }
        if($type === 'class'){
            $classList = Classes::all();
            $enrolledList = Enrolled::all();
            return view('teacher.classes.classlist')->with(['enrolledList'=>$enrolledList, 'classList'=>$classList, 'type' => $type]);
        }
    }

    public function assignmentsList(){
        $types = array('Lab', 'CTF', 'B2R');
        $classes = Classes::all();
        $assignments = Assignments::all();
        return view('teacher.classwork.assignments')->with(['types' => $types, 'classes' => $classes, 'assignments' => $assignments]);
    }


    public function apiGetTeachers(){
        return DB::table('teachers')->pluck('name');
    }


    public function apiGetStudents(){
        return DB::table('students')->select('name', 'first', 'last')->get();
    }
}
