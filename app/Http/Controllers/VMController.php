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
            $this->createB2R($data);
        }else if($request->input('type') == 'Lab'){
            $this->createLab($data);
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
        $vm->destroyVM();
        //$vm->delete();
        return redirect(route('teacher.vm'));
    }


    protected function create(){
        return view('teacher.vmcreate');
    }

    private function createB2R($data){
        VM::create([
            'name' => $data['name'],
            'points' => $data['points'],
            'os' => $data['os'],
            'ip' =>  $data['ip'],
            'file' =>'Placeholder',
            'status' => False,
            'icon' => $data['icon'],
            'description' => $data['description'],            
        ]);

        #create b2rflags with linked vm name
        B2RFlags::create([
            'b2r_name' => $data['name'],
            'user_flag' => md5(Str::random(config('flag.random'))),         
            'root_flag' => md5(Str::random(config('flag.random'))),
        ]);
    }

    private function createLab($data){
        VM::create([
            'name' => $data['name'],
            'points' => $data['points'],
            'os' => $data['os'],
            'ip' =>  $data['ip'],
            'file' =>'Placeholder',
            'status' => False,
            'icon' => $data['icon'],
            'description' => $data['description'],            
        ]);

        #Seed level flags
        for($i = 1; $i <= $data['levels']; $i++){
            LabFlags::create([
                'lab_name' => $data['name'],
                'level' => $i,
                'flag' => md5(Str::random(config('flag_random'))),
            ]);
        }
    }


}


