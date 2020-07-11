<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

use App\Relations\EmptyRelation;

class Assignments extends Model
{
    //Setup table information
	protected $table = 'assignments';

	//Mass fillable arrays
	protected $fillable = [
		'class_id', 'prefix', 'model_id', 'start_date', 'end_date',
	];

	public function lab(){
		if($this->prefix === 'Lab'){
			return $this->hasOne('App\Models\LabsAssigned', 'id', 'model_id');
		}else{
			return new EmptyRelation();
		}
	}

	public function ctf(){
		if($this->prefix === 'CTF'){
			return $this->hasOne('App\Models\CtfsAssigned', 'id', 'model_id');
		}else{
			return new EmptyRelation();
		}
	}

	public function b2r(){
		if($this->prefix === 'B2R'){
			return $this->hasOne('App\Models\B2RsAssigned', 'id', 'model_id');
		}else{
			return new EmptyRelation();
		}
	}


	public static function boot() {
        parent::boot();

        //Delete event to delete entries in other tables/files
        static::deleting(function($assignment) { 
        	if($assignment->prefix === 'Lab'){
        		$assignment->lab()->delete();
        	}else if($assignment->prefix === 'CTF'){
        		$assignment->ctf()->delete();
        	}else if($assignment->prefix === 'B2R'){
        		$assignment->b2r()->delete();
        	}
        	
        
        });
    }

}
