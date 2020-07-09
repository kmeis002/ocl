<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\LabHints;
use App\Models\LabFlags;

/*
|--------------------------------------------------------------------------
| Hints Controller
|--------------------------------------------------------------------------
|
| CRUD for hints.
|
| To-Do:
| - Endpoints (will work when Frontend begins)
|
|
*/


class LabHintController extends Controller
{

    public function apiCreate(Request $request, $name){
        $levels = LabFlags::where(['lab_name' => $name])->get()->count();

        $v = Validator::make($request->all(), [
                'hint' => 'required',
                'level' => [ 'required', 'numeric', 'min:1', 'max:'.$levels ],
            ]);


        if($v->fails()){
            return response()->json(['msg' => 'Validation failed'], 500);
        }

        LabHints::create([
            'lab_name' => $name,
            'hint' => $request->input('hint'),
            'level' => $request->input('level'),
        ]);

    }

    public function apiUpdate(Request $request, $id){
        foreach ($request->all() as $hint) {
            
            $v = Validator::make($hint, [
                'id' => ['required'],
                'hint' => ['required'],
                'level' => ['required', 'numeric'],
            ]);

            if($v->fails()){
                return response()->json(['msg' => 'Validation failed'], 401);
            }


            $h = LabHints::find($hint['id']);
            $h->hint = $hint['hint'];
            $h->level = $hint['level'];
            $h->save();
        }
    }

    public function apiDestroy($id){
    	$hint = LabHints::find($id);
    	$hint->delete();
    }

    //api method for revealing hints via ajax (still need to add updating functionality for student tracking)
    public function reveal(Request $request){
        $request->validate([
            'lab_name' => 'required',
            'hint_num' => 'required|numeric'
        ]); 

        $lab = $request->input('lab_name');
        $hint = $request->input('hint_num');

        $hint = LabHints::where(['lab_name' => $lab])->get()[$hint]['hint'];

        return response()->json(['hint' => $hint]);
    }

}
