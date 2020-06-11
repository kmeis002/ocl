<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\VM;

class VMController extends Controller
{
    //Test controller to get use to VM Model. 

    public function __construct(){
    	$this->middleware('auth:teacher');
    }

    public function show(){
    	return view('teacher.vmtest');
    }

    public function upload(Request $request){
    	//Validate form request
    	$this->validator($request->all())->validate();

    	//Create VM
    	$this->create($request->all());

    	//redirect to form
    	return redirect(route('teacher.vm'));



    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'points' => ['required', 'numeric'],
            'os' => ['required'],
            'ip' => ['required', 'ip'],
            'icon' => ['required', 'string'],
            'description' => ['required','string'],
        ]);
    }

    protected function create(array $data)
    {
        return VM::create([
            'name' => $data['name'],
            'points' => $data['points'],
            'os' => $data['os'],
            'ip' =>  $data['ip'],
            'icon' => $data['icon'],
            'description' => $data['description'],            
        ]);
    }
}
