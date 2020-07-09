<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Skills;

class SkillController extends Controller
{
    public function apiGet(){
    	return Skills::all();
    }

}
