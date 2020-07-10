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


class Courses extends Model
{
    
	//Setup table information
	protected $table = 'courses';
	protected $primaryKey = 'name';
	protected $keyType = 'string';

	//Mass fillable arrays
	protected $fillable = [
		'name',
	];

	public function class(){
		return $this->hasMany('App\Models\Classes', 'course', 'name');
	}


	public static function boot() {
        parent::boot();

        //Delete event to delete entries in other tables/files
        static::deleting(function($course) { 
        	//Delete hasMany relations
        	$classes = $course->class()->get();

        	forEach($classes as $class){
        		$class->enrolled()->delete();
        	}

        	$course->class()->delete();
        });
    }

}