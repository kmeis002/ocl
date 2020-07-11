<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| Hints Model
|--------------------------------------------------------------------------
|
| Model for text hints.
|
|
*/


class Classes extends Model
{
    
	//Setup table information
	protected $table = 'classes';
	protected $primaryKey = 'id';

	//Mass fillable arrays
	protected $fillable = [
		'course', 'bell', 'teacher', 
	];



	public static function boot() {
        parent::boot();

        //Delete event to delete entries in other tables/files
        static::deleting(function($class) { 
        	$class->enrolled()->delete();
        });
    }

    public function enrolled(){
    	return $this->hasMany('App\Models\Enrolled', 'class_id', 'id');
    }

    public function assignments(){
        return $this->hasMany('App\Models\Assignments', 'class_id', 'id');
    }

}