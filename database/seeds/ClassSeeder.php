<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$courses = DB::table('courses')->select('name')->get();
    	$teachers = DB::table('teachers')->select('name')->get();

    	for($i=0; $i<8; $i++){ 
	        DB::table('classes')->insert([
	        	'course' => $courses[rand(1, count($courses))-1]->name,
	        	'teacher' => $teachers[rand(1, count($teachers))-1]->name,
	        	'bell' => rand(1,10),
        		'created_at' => \Carbon\Carbon::now(),
        		'updated_at' => \Carbon\Carbon::now(),
	        ]);
   	 	}
    }
}
