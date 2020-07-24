<?php

namespace App\Http\Api;

use Illuminate\Http\Request;

use App\Models\Labs;

class ApiLabController extends Controller
{
    public function apiGetEditInfo($name){
        $lab = Labs::find($name);
        $lab->flags;
        $lab->skills;
        return response()->json(['lab'=>$lab]);

    }


    public function apiGetHints($name){
        $lab = Labs::find($name);
        $hints = $lab->hints()->paginate(10);

        return response()->json(['hints' => $hints, 'levels' => LabFlags::where(['lab_name' => $name])->get()->count()]);
    }

    public function apiDestroy($name){
        $Lab = Labs::find($name);
        $Lab->delete();
    }

    public function apiGetAll(){
        return Labs::all()->pluck('name');
    }

}