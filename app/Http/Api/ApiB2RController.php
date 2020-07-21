<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\B2R;

class ApiB2RController extends Controller
{
    
    public function apiGetEditInfo($name){
        $b2r = B2R::find($name);
        $b2r->flags;
        $b2r->skills;
        return response()->json(['b2r'=>$b2r]);
    }


    public function apiGetHints($name){
    	$b2r = B2R::find($name);
    	$hints = $b2r->hints;

    	return response()->json($hints);
    }


    public function apiDestroy($name){
        $B2R = B2R::find($name);
        $B2R->delete();
    }

    public function apiGetAll(){
        return B2R::all()->pluck('name');
    }

}
