<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hints;

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


class HintController extends Controller
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
    		'hint' = > 'required'])

    	$hint = Hints::find($id);

    	$hint->hint = $request->input('hint');
    	$hint->save();
    }

    public function destroy($id){
    	$hint = Hints::find($id);
    	$hint->delete();
    }

}
