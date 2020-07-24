<?php

namespace App\Http\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use App\Models\B2RHints;

class ApiB2RHintController extends Controller
{
    public function apiCreate(Request $request, $name){

        $v = Validator::make($request->all(), [
                'hint' =>'required',
                'is_root' => ['required', Rule::in(['false', 'true'])],
            ]);

        if($v->fails()){
            return response()->json(['msg' => 'Validation failed'], 500);
        }

        B2RHints::create([
            'b2r_name' => $name,
            'hint' => $request->input('hint'),
            'is_root' => $request->input('is_root')=="true",
        ]);

	}

    public function apiUpdate(Request $request){

        foreach ($request->all() as $hint) {
            
            $v = Validator::make($hint, [
                'id' => ['required'],
                'hint' => ['required'],
                'is_root' => ['required', 'boolean'],
            ]);

            if($v->fails()){
                return response()->json(['msg' => 'Validation failed'], 401);
            }
            $h = B2RHints::find($hint['id']);
            $h->hint = $hint['hint'];
            $h->is_root = $hint['is_root'];
            $h->save();
        }
    }

    public function apiDestroy($id){
    	$hint = B2RHints::find($id);
    	$hint->delete();
    }
}
