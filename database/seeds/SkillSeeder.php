<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = array('Linux Commands', 'Windows Commands', 'Bash Scripting', 'XSS', 'CSRF', 'SQL Injection', 'PHP Injection', 'Buffer Overflows', 'OSI Model', 'Networking', 'Enumeration', 'Deserialization Attack', "RCE", 'Social Engineering', 'Phishing', 'War Driving', 'Cryptography', 'Password Cracking', 'Privilege Escalation', 'Reverse Engineering');

        foreach($skills as $skill){
        	DB::table('skills')->insert([
        		'name' => $skill,
        		'created_at' => \Carbon\Carbon::now(),
        		'updated_at' => \Carbon\Carbon::now(),
        	]);
        }
       
    }
}
