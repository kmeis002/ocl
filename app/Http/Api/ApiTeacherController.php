<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ApiTeacherController extends Controller
{
    public function apiGetTeachers(){
        return DB::table('teachers')->pluck('name');
    }


    public function apiGetStudents(){
        return DB::table('students')->select('name', 'first', 'last')->get();
    }
}