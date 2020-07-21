<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skills extends Model
{
    //Setup table information
	protected $table = 'skills';


	//Mass fillable arrays
	protected $fillable = [
		'name',
	];

	public function vms(){
		return $this->hasMany('App\Models\VMSkills', 'skill', 'name');
	}


	public static function boot() {
        parent::boot();

        //Delete event to delete entries in other tables/files
        static::deleting(function($skill) { 
        	$relations = $skill->vms()->get();

        	foreach($relations as $r){
        		$r->delete();
        	}
        });
    }

}
