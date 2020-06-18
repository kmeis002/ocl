<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mqtt;

class TeacherController extends Controller
{

	public function __construct(){

        $this->middleware('auth:teacher');

    }


    public function show(){

    	return view('teacher.home');

    }
3

}
