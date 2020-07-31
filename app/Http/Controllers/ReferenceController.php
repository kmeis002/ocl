<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\References;
use App\Models\Sections;
use App\Models\ReferenceSkills;

class ReferenceController extends Controller
{
    public function create(Request $request){

    	$request->validate([
    		'name' => ['required', 'string'],
    	]);

    	References::create([
    		'name' => $request->input('name'),
    	]);

    }

    public function createSection(Request $request, $id){

    	$request->validate([
    		'name' => ['string', 'required'],
    		'content' => ['string', 'required'],
    	]);

    	Sections::create([
    		'references_id' => $id,
    		'name' => $request->input('name'),
    		'content' => $request->input('content'),
    	]);
    }

    public function getSectionNames($id){
    	$sections = References::find($id)->sections()->select('id', 'name')->get();
    	return $sections;
    }

    public function getSkills($id){
        $skills = References::find($id)->skills()->get();
        return $skills;
    }

    public function getSection($id){
        $section = Sections::find($id);
        return $section;
    }

    public function updateSection(Request $request, $id){
        $request->validate([
            'name' => ['string', 'required'],
            'content' => ['string', 'required'],
        ]);

        $section = Sections::find($id);

        $section->name = $request->input('name');
        $section->content = $request->input('content');
        $section->save();
    }

    public function deleteSection($id){
        $section = Sections::find($id);
        $section->delete();
    }

    public function delete($id){
        $reference = References::find($id);
        $reference->delete();
    }

    public function deleteSkill(Request $request, $id){
        $request->validate([
            'skill' => ['required', 'string'],
        ]);

        $skill = ReferenceSkills::where([['reference_id', '=', $id],['skill_name', '=', $request->input('skill')]]);
        $skill->delete();
    }

    public function addSkill(Request $request, $id){
        $request->validate([
            'skill' => ['required', 'string'],
        ]);

        ReferenceSkills::create([
            'reference_id' => $id,
            'skill_name' => $request->input('skill'),
        ]);
    }

}
