<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    //Array for sample font-awesome icons
    protected $icons = array("fas fa-heart-broken", "fas fa-headphones", "fas fa-gas-pump", "fas fa-truck-monster", "fas fa-blender", 'fas fa-hiking');
    protected $os = array('Linux','Windows','FreeBSD');

    public function run()
    {
    	$name = Str::random(12);
    	$os = array('Linux','Windows','FreeBSD');
    	$icons = array("fas fa-heart-broken", "fas fa-headphones", "fas fa-gas-pump", "fas fa-truck-monster", "fas fa-blender", 'fas fa-hiking');

        DB::table('vms')->insert([
        	'name' => $name,
        	'points' => rand(10,100),
        	'file' => $name.'.ova',
        	'ip' => rand(1,255).'.'.rand(1,255).'.'.rand(1,255).'.'.rand(1,255),
        	'os' => $os[array_rand($os)],
        	'description' => Str::random(500),
        	'icon' => $icons[array_rand($icons)],
        	'status' => rand(0,1),

        ]);
    }
}
