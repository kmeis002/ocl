<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$first = array('John', 'Jessie', 'Mark', 'Natalie', 'Tom', 'Erik', 'Karl', 'Bart', 'Alyssa', 'Melanie', 'Cordelia', 'Ashton', 'Emil', 'Emily', 'Robert');
    	$last = array('Gamache', 'Meister', 'Conner', 'Clark', 'Smith', 'Beleren', 'Fisher', 'Bowman', 'Trombley', 'Amos', 'Pollard');
    	

    	for($i = 0; $i<30; $i++){
    		$name = $first[array_rand($first)].'.'.$last[array_rand($last)].'.'.rand(10,99);
        	$this->make($name, explode('.', $name)[0], explode('.', $name)[1]);
        }
    }

    public function make($name, $first, $last){
        DB::table('students')->insert([
        	'name' => $name,
        	'first' => $first,
        	'last' => $last,
        	'password' => md5(Str::random(50)),
        	'total_score' => 0,
        	'created_at' => \Carbon\Carbon::now(),
        	'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
