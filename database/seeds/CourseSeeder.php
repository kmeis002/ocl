<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = array('Introduction to Cybersecurity', 'Advanced Cybersecurity', 'PicoCTF', 'CyberPatriot');

        forEach($courses as $course){
	        DB::table('courses')->insert([
	        	'name' => $course,
        		'created_at' => \Carbon\Carbon::now(),
        		'updated_at' => \Carbon\Carbon::now(),
	        ]);
	    }
    }
}
