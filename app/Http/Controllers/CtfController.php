<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ctfs;

/*
|--------------------------------------------------------------------------
| CTF Controller
|--------------------------------------------------------------------------
|
| CRUD Controller for creating Capture the Flag challenges. CTFs are .zip 
| files that contain a challenge to obtain flag. CTFs name should be the 
| same as the zip uploaded.
|
| IE: The challenge "Try and Find me" will be uploaded as "Try_and_Find_me.zip".
|
| To-Do:
| 
|
*/

class CtfController extends Controller
{
	public function create(Request $request){

	}
    
    public function store(Request $request){
    	$request->validate([
    		'name' => 'requried',
    		'points' => 'required|numeric',
    		'description' => 'required',
    		'flag' => 'required'
    	]);

    	Ctfs::create([
    		'name' => $request->input('name'),
    		'points'	=> $request->input('points'),
    		'description' => $request->input('description'),
    		'flag' => $request->input('flag'),
    	]);
    }

    public function update(Request $request, $id){
    	$request->validate([
    		'name' => 'requried',
    		'points' => 'required|numeric',
    		'description' => 'required',
    		'flag' => 'required'
    	]);

    	$ctf = Ctfs::find($id);

    	$ctf->name = $request->input('name');
    	$ctf->points = $request->input('points');
    	$ctf->description = $request->input('description');
    	$ctf->flag = $request->input('flag');
    	$ctf->save();
    }

    public function destroy($id){
    	$ctf = Ctfs::find($id);
    	$ctf->delete();
    }

    public function apiGetAll(){
        return Ctfs::all()->pluck('name');
    }
}
