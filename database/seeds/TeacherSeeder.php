<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->make('Mr. Meister');
    	$this->make('Mr. Connor');
    	$this->make('Ms. Sicka');
    	$this->make('Mr. McDonald');
    }

    public function make($name){
        DB::table('teachers')->insert([
        	'name' => $name,
        	'password' => md5(Str::random(50)),
        	'api_token' => Str::random(50),
        	'email' => $name.'@email.com',
        	'created_at' => \Carbon\Carbon::now(),
        	'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
