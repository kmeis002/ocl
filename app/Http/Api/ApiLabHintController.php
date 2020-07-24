<?php

namespace App\Http\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use App\Models\LabHints;
use App\Models\HintsUsed;

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


class ApiLabHintController extends Controller
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
}
