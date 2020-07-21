<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'ctf-name' => ['required', 'string'],
            'pts' => ['required', 'numeric', 'min:0', 'max:100'],
            'category' => ['required', 'string'],
            'flag' => ['required', 'string'],
            'icon' => ['required', 'string'],
        ]);

        Ctfs::Create([
            'name' => $request->input('ctf-name'),
            'points' => $request->input('pts'),
            'category' => $request->input('category'),
            'flag' => $request->input('flag'),
            'icon' => $request->input('icon'),
            'description' => $request->input('description'),
        ]);

        return redirect('/teacher/resources/list/ctf');
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

    public function destroy($id){
    	$ctf = Ctfs::find($id);
    	$ctf->delete();
    }

    public function apiGetAll(){
        return Ctfs::all()->pluck('name');
    }

    public function getEditInfo($name){
        return Ctfs::find($name);
    }


    public function update(Request $request, $name){
        $request->validate([
            'edit-pts' => ['required','numeric','max:100','min:0'],
            'edit-icon-picker' => 'required',
            'edit-description' => ['required', 'string'],
            'edit-flag' => ['required', 'string'],
            'edit-category' => ['required', 'string'],
        ]);

        $ctf = Ctfs::find($name);
        $ctf->points = $request->input('edit-pts');
        $ctf->icon = $request->input('edit-icon-picker');
        $ctf->description = $request->input('edit-description');
        $ctf->flag = $request->input('edit-flag');
        $ctf->category = $request->input('edit-category');

        $ctf->save();


        return redirect('/teacher/resources/list/ctf')->with(['updated' => $name]);
    }

    public function deleteZip($name){
        $filename = strtolower($name);
        $filename = str_replace(' ', '_', $filename);

        if(Storage::exists('/ctf/'.$filename.'.zip')){
            Storage::delete('/ctf/'.$filename.'.zip');
            $ctf = Ctfs::find($name);
            $ctf->file = null;
            $ctf->save();
            return redirect('/teacher/resources/list/ctf')->with(['updated' => $name]);
        }else{
            return response()->json(['message' => 'file not found'], 500);
        }
    }
}
