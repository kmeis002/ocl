<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\VMSkills;

class VMSkillController extends Controller
{
    
    public function apiCreate(Request $request, $name){
    	VMSkills::Create([
    		'vm_name' => $name,
    		'skill' => $request->input('skill'),
    	]);
    }

    public function apiDestroy(Request $request, $name){
    	$skill = VMSkills::find($request->input('id'));
    	$skill->delete();
    }
}
