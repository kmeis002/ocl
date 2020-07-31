<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class References extends Model
{
    //Setup table information
	protected $table = 'refs';

	//Mass fillable arrays
	protected $fillable = [
		'name',
	];

	public function sections(){
		return $this->hasMany('App\Models\Sections', 'references_id', 'id');
	}

	public function skills(){
		return $this->hasMany('App\Models\ReferenceSkills', 'reference_id', 'id');
	}

	public static function boot() {
        parent::boot();

        //Delete event to delete entries in other tables/files
        static::deleting(function($reference) { 
            //Delete hasMany relations
            $reference->sections()->delete();
            $reference->skills()->delete();
        });
    }
}
