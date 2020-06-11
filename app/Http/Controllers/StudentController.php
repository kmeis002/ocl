<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{

	public function __construct(){

        $this->middleware('auth:student');

    }


    public function show(){

    	return view('student.home');

    }
}
