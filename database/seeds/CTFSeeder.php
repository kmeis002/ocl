<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CTFSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
    	$name = Str::random(12);
    	$icons = array("fas fa-heart-broken", "fas fa-headphones", "fas fa-gas-pump", "fas fa-truck-monster", "fas fa-blender", 'fas fa-hiking');
    	$cats = array("Cryptography", "Reverse Engineering", "PHP", "Bash", "Steganography");

        DB::table('ctfs')->insert([
        	'name' => $name,
        	'points' => rand(0,100),
        	'file' => $name.'.zip',
        	'description' => Str::random(1000),
        	'icon' => $icons[array_rand($icons)],
        	'flag' => md5(Str::random(config('flag.random'))),
        	'category' => $cats[array_rand($cats)],
        	'created_at' => \Carbon\Carbon::now(),
        	'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
