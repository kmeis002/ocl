<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Assignments;
use App\Models\LabsAssigned;
use App\Models\CtfsAssigned;
use App\Models\B2RsAssigned;
use App\Models\Labs;

class AssignmentController extends Controller
{
   
	public function create(Request $request){
		$request->validate([
			'model-select' => ['required'],
			'class-select' => ['required'],
			'start-date' => ['required', 'date'],
			'end-date' => ['required', 'date', 'after:start-date'],
		]);

		forEach($request->input('class-select') as $class){
			if($request->input('model-select') === 'Lab'){
				$a = LabsAssigned::create([
				]);
			}
			if($request->input('model-select') === 'CTF'){
				$a = CtfsAssigned::create([
				]);
			}
			if($request->input('model-select') === 'B2R'){
				$a = B2RsAssigned::create([
				]);
			}

			Assignments::create([
				'class_id' => $class,
				'model_id' => $a->id,
				'prefix' => $request->input('model-select'),
				'start_date' => $request->input('start-date'),
				'end_date' => $request->input('end-date'),
			]);
		}

		return redirect('/teacher/classwork/assignments');
	}

	public function apiUpdate(Request $request, $id){
		$assignment = Assignments::find($id);

		$request->validate([
			'edit-model-select' => ['required'],
		]);

		if($assignment->prefix === "Lab"){
			$modelAssigned = LabsAssigned::find($assignment->model_id);
			$modelAssigned->lab_name = $request->input('edit-model-select');
			$modelAssigned->start_level = $request->input('start-flag');
			$modelAssigned->end_level = $request->input('end-flag');
			$modelAssigned->save();

		}else if($assignment->prefix === 'B2R'){
			$modelAssigned = B2RsAssigned::find($assignment->model_id);
			$modelAssigned->b2r_name = $request->input('edit-model-select');
			if($request->input('flag-select') === 'both'){
				$modelAssigned->user = true;
				$modelAssigned->root = true;
			}else if($request->input('flag-select') === 'root'){
				$modelAssigned->root = true;
			}else{
				$modelAssigned->user = true;
			}

			$modelAssigned->save();
		}else if($assignment->prefix === 'CTF'){
			$modelAssigned = CtfsAssigned::find($assignment->model_id);
			$modelAssigned->ctf_name = $request->input('edit-model-select');
			$modelAssigned->save();
		}

	}

	public function apiDestroy($id){
		$assignment = Assignments::find($id);
		$assignment->delete();
	}

	public function apiGetLevels($id){
		$assignment = Assignments::find($id);
		if($assignment->prefix === 'Lab'){
			$labAssigned = LabsAssigned::find($assignment->model_id);
			return response()->json(['start' => $labAssigned->start_level, 'end' => $labAssigned->end_level]);
		}else{
			return response()->json(['message' => 'Only Lab assignments have levels']);
		}
	}

	public function apiGetModelName($id){
		$assignment = Assignments::find($id);
		if($assignment->prefix === 'Lab'){
			$name = LabsAssigned::find($assignment->model_id)->lab_name;
		}else if($assignment->prefix === 'CTF'){
			$name = CtfsAssigned::find($assignment->model_id)->ctf_name;
		}else if($assignment->prefix === 'B2R'){
			$name = B2RsAssigned::find($assignment->model_id)->b2r_name;
		}
		return response()->json(['name' => $name]);
	}



}
