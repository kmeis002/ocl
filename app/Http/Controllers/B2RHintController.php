<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\B2RHints;

class B2RHintController extends Controller
{
    public function create(Request $request){

	}
    
    public function store(Request $request){
    	$request->validate([
    		'vm_name' => 'required',
    		'hint' => 'required']);

    	Hints::create([
    		'vm_name' => $request->input('vm_name'),
    		'hint'	=> $request->input('hint'),
    	]);
    }

    public function update(Request $request, $id){
    	$request->validate([
    		'hint' => 'required'
        ]);

    	$hint = Hints::find($id);

    	$hint->hint = $request->input('hint');
    	$hint->save();
    }

    public function destroy($id){
    	$hint = Hints::find($id);
    	$hint->delete();
    }

    //api method for revealing hints via ajax (still need to add updating functionality for student tracking)
    public function reveal(Request $request){
        $request->validate([
            'b2r_name' => 'required',
            'is_root' => 'required',
            'hint' => 'required|numeric',
        ]); 

        $b2r = $request->input('b2r_name');
        $root = $request->input('is_root');
        $num = $request->input('hint');

        $hint = B2RHints::where(['b2r_name' => $b2r, 'is_root' => filter_var($root, FILTER_VALIDATE_BOOLEAN)])->get()[$num]['hint'];

        return response()->json(['hint' => $hint]);
    }

}
