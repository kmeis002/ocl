<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\VM;
use App\Models\LabHints;
use App\Models\LabFlags;
use App\Models\VMSkills;

class PageTest extends Controller
{
    
    public function test($name){
    	$vm = VM::find($name);
    	$hints = LabHints::where('lab_name', $vm->name)->get();
    	$skills = VMSkills::where('vm_name', $vm->name)->get();
    	$lvls = LabFlags::where('lab_name', $vm->name)->count();
    	return view('student.lab')->with(['vm' => $vm, 'skills' => $skills, 'lvls' => $lvls, 'hints' => $hints]);
    }
}
