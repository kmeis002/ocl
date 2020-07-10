<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use App\Models\B2R;
use App\Models\B2RFlags;
use App\Models\VMSkills;

class B2RController extends Controller
{
    
    public function apiGetEditInfo($name){
        $b2r = B2R::find($name);
        $b2r->flags;
        $b2r->skills;
        return response()->json(['b2r'=>$b2r]);

    }

    public function update(Request $request, $name){
        $request->validate([
        	'edit-pts' => ['required','numeric','max:100','min:0'],
        	'edit-ip' => ['required','ip','unique:vms,ip,'.$name.',name'],
        	'edit-os-select' => 'required',
        	'edit-icon-picker' => 'required',
        	'edit-description' => 'required',
        	'edit-user-flag' => 'required',
        	'edit-root-flag' => 'required',
        ]);


        $b2r = B2R::find($name);
        $b2r->points = $request['edit-pts'];
        $b2r->os = $request['edit-os-select'];
        $b2r->ip = $request['edit-ip'];
        $b2r->icon = $request['edit-icon-picker'];
        $b2r->description = $request['edit-description'];
        $b2r->save();

        $flags = B2RFlags::find($name);
        $flags->user_flag = $request['edit-user-flag'];
        $flags->root_flag = $request['edit-root-flag'];
        $flags->save();

        //update skills
        $skillCount = VMSkills::where(['vm_name' => $name])->get()->count();
        for($i = 0; $i < $skillCount; $i++){
            $id = VMSkills::where(['vm_name' => $name])->get()[$i]['id'];
            $s = VMSkills::find($id);
            $s->skill = $request->input('skill-'.$id);
            $s->save();
        }


        return redirect('/teacher/resources/list/b2r')->with(['updated' => $name]);
    }

    public function apiGetHints($name){
    	$b2r = B2R::find($name);
    	$hints = $b2r->hints;

    	return response()->json($hints);
    }

    public function create(Request $request){
        $request->validate([
            'vm-name' => ['required', 'unique:App\Models\VM,name'],
            'pts' => ['required', 'numeric', 'max:100', 'min:0'],
            'ip' => ['ip','required','unique:App\Models\VM,ip'],
            'os-select' => 'required',
            'icon' => 'required',
            'description' => '',
            'user-flag' => Rule::requiredIf($request->input('root-flag') !== null),
            'root-flag' => Rule::requiredIf($request->input('user-flag') !== null),
        ]);

        B2R::create($request->all());

        return redirect('/teacher/list/b2r');
    }

    public function apiDestroy($name){
        $B2R = B2R::find($name);
        $B2R->delete();
    }


}
