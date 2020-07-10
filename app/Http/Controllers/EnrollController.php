<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Enrolled;
use App\Models\Student;

class EnrollController extends Controller
{
    

	public function apiEnroll(Request $request, $id){
		$request->validate([
			'student' => 'required',
		]);

		Enrolled::create([
			'student' => $request->input('student'),
			'class_id' => $id,
		]);
	}

    public function apiGetEnrolled($id){
    	$classEnrolled = Enrolled::where(['class_id'=>$id])->get();
    	$studentList = array();
    	forEach($classEnrolled as $studentCollection){
    		$studentName = $studentCollection['student'];
    		array_push($studentList, Student::where(["name" => $studentName])->get());
    	}
    	return $studentList;
    }

    public function apiUnenroll(Request $request, $id){
    	$request->validate([
			'studentName' => ['required'],
		]);

		$enrolled = Enrolled::where(['class_id' => $id, 'student' => $request->input('studentName')])->get()[0];
		$enrolled->delete();
    }
}
