<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\VM;

/*
|--------------------------------------------------------------------------
| Virtual Machine Controller
|--------------------------------------------------------------------------
|
| Controlls VM Model including basic "CRUD" functionality. 
| VMs are represented by ova's currently and controlled via a system script
| and a "supervisor" controller. This is the teacher logic for managing vms.
|
| To-Do:
|
| - File uploads (.ova) + Verification
| - Input sanitization (?)
| - Start/Stop/Reset Controls
| - ModifyVM Controls (Should be automatic by script, but, possibly want to modify on the fly from this controller)
|
*/



class VMController extends Controller
{

    private $files = 'files/vm';

    public function __construct(){
    	$this->middleware('auth:teacher');
    }

    public function store(Request $request){


        $data = $this->validator($request);

        if($request->input('type') == 'Boot2Root'){
            VM::createB2R($data);
        }else if($request->input('type') == 'Lab'){
            VM::createLab($data);
        }
 
        
        
        //Storage::disk('sftp')->putFileAs('vm/', $data['file'], $data['name']);

        return redirect(route('teacher.vm'));
    }

    public function update(Request $request, $name){
        $data = $this->validator($request);

        $vm = VM::find($name);
        $vm->name = $data['name'];
        $vm->points = $data['points'];
        $vm->os = $data['os'];
        $vm->ip = $data['ip'];
        $vm->file = 'Placeholder';
        $vm->icon = $data['icon'];
        $vm->description = $data['description'];
        $vm->save();

        return redirect(route('teacher.vm'));
    }


    protected function validator(Request $request){
        return $request->validate([
            'name' => ['required','unique:vms,name', 'max:25'],
            'ip' => ['required','unique:vms,ip','ip'],
            'points' => ['required','numeric','max:100','min:0'],
            'os' => ['required'],
            'levels' => ['required', 'numeric'],
            'type' => ['required'],
            'icon' => ['required'],
            'description' => ['required','string'],
        ]);
    }

    public function edit($name){
        $vm=VM::find($name);
        return view('teacher.vmedit')->with('vm', $vm);
    }
    public function index(){
        $vms = VM::all();
    	return view('teacher.vmindex')->with('vms', $vms);
    }

    public function show($name){
        $vm = VM::find($name);
        return view('teacher.vmshow')->with('vm', $vm);
        }


    public function destroy($name){
        $vm = VM::find($name);
        Storage::disk('sftp')->delete('vm/'.$vm->name);
        $vm->delete();
        return redirect(route('teacher.vm'));
    }


    protected function create(){
        return view('teacher.vmcreate');
    }


}


