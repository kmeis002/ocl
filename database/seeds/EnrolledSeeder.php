<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnrolledSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = DB::table('classes')->select('id')->get();
        $students = DB::table('students')->select('name')->get();

        for($i=0; $i<count($students)*2; $i++){
      	  	DB::table('enrolled')->insert([
      	  		'class_id' => $classes[rand(1, count($classes)-1)]->id,
      	  		'student' => $students[rand(1, count($students)-1)]->name,
        	]);
      	}
    }
}
