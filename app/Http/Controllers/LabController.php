<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use App\Models\Labs;
use App\Models\LabFlags;
use App\Models\VMSkills;
use App\Models\Skills;

class LabController extends Controller
{
    public function getEditInfo($name){
        $lab = Labs::find($name);
        $lab->flags;
        $lab->skills;
        return response()->json(['lab'=>$lab]);

    }


    public function getHints($name){
        $lab = Labs::find($name);
        $hints = $lab->hints()->paginate(10);

        return response()->json(['hints' => $hints, 'levels' => LabFlags::where(['lab_name' => $name])->get()->count()]);
    }

    public function update(Request $request, $name){

        $lvlCount = LabFlags::where(['lab_name'=>$name])->get()->count();
        $request->validate([
        	'edit-pts' => ['required','numeric','max:100','min:0'],
        	'edit-ip' => ['required','ip','unique:vms,ip,'.$name.',name'],
        	'edit-os-select' => 'required',
        	'edit-icon-picker' => 'required',
        	'edit-description' => 'required',
        ]);


        $lab = Labs::find($name);
        $lab->points = $request['edit-pts'];
        $lab->os = $request['edit-os-select'];
        $lab->ip = $request['edit-ip'];
        $lab->icon = $request['edit-icon-picker'];
        $lab->description = $request['edit-description'];
        $lab->save();

        //update flags
        for($i=1; $i<=$lvlCount; $i++){
            $flag = LabFlags::where(['lab_name' => $name, 'level'=>$i])->get()[0];
            $flag->flag = $request->input('flag-'.$i);
            $flag->save();
        }

        //update skills
        $skillCount = VMSkills::where(['vm_name' => $name])->get()->count();
        for($i = 0; $i < $skillCount; $i++){
            $id = VMSkills::where(['vm_name' => $name])->get()[$i]['id'];
            $s = VMSkills::find($id);
            $s->skill = $request->input('skill-'.$id);
            $s->save();
        }


        return redirect('/teacher/resources/list/lab')->with(['updated' => $name]);
    }


    public function create(Request $request){
        $request->validate([
            'vm-name' => ['required', 'unique:App\Models\VM,name'],
            'pts' => ['required', 'numeric', 'max:100', 'min:0'],
            'ip' => ['ip','required','unique:App\Models\VM,ip'],
            'os-select' => 'required',
            'icon' => 'required',
            'description' => '',
        ]);

        Labs::create($request->all());

        return redirect('/teacher/resources/list/lab');
    }

    public function destroy($name){
        $Lab = Labs::find($name);
        $Lab->delete();
    }

    public function getAll(){
        return Labs::all()->pluck('name');
    }


    public function studentGet($name){
        $lab = Labs::find($name);
        $lab->skills;

        $levelCount = $lab->countLevels();
        $hints = $lab->getHints();

        $hintsUsed = Auth::user()->HintsCheck($name);
        $flagCheck = Auth::user()->LabCheck($name);
        
        return response()->json(['machine'=>$lab, 'levels' => $levelCount, 'hints'=>$hints, 'hintsUsed' => $hintsUsed, 'flags' => $flagCheck], 200);
    }

    
}
