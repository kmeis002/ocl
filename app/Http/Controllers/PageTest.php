<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\VM;
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
    	$vm = VM::find($name);
    	$hints = LabHints::where('lab_name', $vm->name)->get();
    	$skills = VMSkills::where('vm_name', $vm->name)->get();
    	$lvls = LabFlags::where('lab_name', $vm->name)->count();
    	return view('student.lab')->with(['vm' => $vm, 'skills' => $skills, 'lvls' => $lvls, 'hints' => $hints]);
    }

    public function b2rtest($name){
    	$vm = VM::find($name);
    	$userHints = B2RHints::where(['b2r_name' => $vm->name, 'is_root' => false])->get();
		$rootHints = B2RHints::where(['b2r_name' => $vm->name, 'is_root' => true])->get();
    	$skills = VMSkills::where('vm_name', $vm->name)->get();
    	return view('student.b2r')->with(['vm' => $vm, 'skills' => $skills, 'user_hints' => $userHints, 'root_hints' => $rootHints]);
    }

    public function machineList($type){
        return view('student.list');
    }

    public function list($type){
        if($type === 'lab'){
            $list = VM::allLabs();
        }
        if($type === 'b2r'){
            $list = VM::allB2R();
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

    public function shuffletest(){
        return view('student.shuffle');
    }
}
