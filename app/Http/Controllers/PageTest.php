<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\VM;
use App\Models\Labs;
use App\Models\B2R;
use App\Models\LabHints;
use App\Models\LabFlags;
use App\Models\Ctfs;
use App\Models\VMSkills;
use App\Models\B2RHints;

class PageTest extends Controller
{
    
    public function home(){
        return view('student.home');
    }

    public function labtest($name){
    	$lab = Labs::find($name);
    	$hints = LabHints::where('lab_name', $lab->name)->get();
    	$skills = VMSkills::where('vm_name', $lab->name)->get();
    	$lvls = LabFlags::where('lab_name', $lab->name)->count();
    	return view('student.lab')->with(['vm' => $lab, 'skills' => $skills, 'lvls' => $lvls, 'hints' => $hints]);
    }

    public function b2rtest($name){
    	$b2r = B2R::find($name);
    	$userHints = B2RHints::where(['b2r_name' => $b2r->name, 'is_root' => false])->get();
		$rootHints = B2RHints::where(['b2r_name' => $b2r->name, 'is_root' => true])->get();
    	$skills = VMSkills::where('vm_name', $b2r->name)->get();
    	return view('student.b2r')->with(['vm' => $b2r, 'skills' => $skills, 'user_hints' => $userHints, 'root_hints' => $rootHints]);
    }

    public function machineList($type){
        return view('student.list');
    }

    public function list($type){
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
            return view('student.list')->with(['list'=>$list, 'type' => $type]);
        }else if($type === 'ctf'){
            return view('student.list')->with(['list'=>$list, 'type' => $type, 'categories' => $categories]);
        }
    }


    public function teacherHome(){
        return view('teacher.home');
    }

    public function teacherList($type){
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
            return view('teacher.list')->with(['list'=>$list, 'type' => $type]);
        }else if($type === 'ctf'){
            return view('teacher.list')->with(['list'=>$list, 'type' => $type, 'categories' => $categories]);
        }
    }
}
