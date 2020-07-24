<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Student;
use App\Models\Labs;
use App\Models\B2R;
use App\Models\Ctfs;
use App\Models\CompletedCtfs;

use App\Charts\ProgressChart;

class StudentController extends Controller
{

	public function __construct(){

        $this->middleware('auth:student');

    }


    public function show(){

    	return view('student.home');

    }

    public function dashboard(){
        $user = Auth::user();
        $completed = $user->completedAssignments();
        $incomplete = $user->incompleteAssignments();
        $progress = new ProgressChart;
        $history = $user->score()->orderBy('id', 'desc')->take(5)->get();
    
        return view('student.dashboard.dashboard')->with(['completed' => $completed, 'incomplete' => $incomplete, 'progress' => $progress, 'history' => $history]);
    }


    public function listResources($type){
        if($type === 'lab'){
            $list = Labs::all();
            $assigned = Auth::user()->labArray();
        }
        if($type === 'b2r'){
            $list = B2R::all();
            $assigned = Auth::user()->b2rArray();
        }
        if($type === 'ctf'){
            $list = Ctfs::all();
            $completed = $this->makeCompletedArray();
            $categories = DB::table('ctfs')->select('category')->distinct()->get();
            $assigned = Auth::user()->ctfArray();
        }


        

        if($type === 'lab' || $type === 'b2r'){
            return view('student.resources.list')->with(['list'=>$list, 'type' => $type, 'assigned' => $assigned]);
        }else if($type === 'ctf'){
            return view('student.resources.list')->with(['list' => $list, 'type' => $type, 'categories' => $categories, 'completed' => $completed, 'assigned' => $assigned]);
        }
    }



    private function makeCompletedArray(){
        $out = array();
        $completed = CompletedCtfs::where('student', '=', Auth::user()->name)->get();

        foreach ($completed as $c) {
            array_push($out, $c->ctf_name);
        }

        return $out;
    }


}
