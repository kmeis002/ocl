<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class LabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$name = Str::random(12);
    	$os = array('Linux','Windows','FreeBSD');
    	$icons = array("fas fa-heart-broken", "fas fa-headphones", "fas fa-gas-pump", "fas fa-truck-monster", "fas fa-blender", 'fas fa-hiking');
        $file = array($name.'.ova', null);
        $fileName = $file[array_rand($file)];
        if($fileName !== null){
            $fileName = strtolower($fileName);
        }

    	//Create VM Model
        DB::table('vms')->insert([
        	'name' => $name,
        	'points' => rand(10,100),
        	'file' => $fileName,
        	'ip' => rand(1,255).'.'.rand(1,255).'.'.rand(1,255).'.'.rand(1,255),
        	'os' => $os[array_rand($os)],
        	'description' => Str::random(500),
        	'icon' => $icons[array_rand($icons)],
        	'status' => rand(0,1),
        	'created_at' => \Carbon\Carbon::now(),
        	'updated_at' => \Carbon\Carbon::now(),
        ]);

        //Make fake ova file
        if($fileName !== NULL){
            $app_path = storage_path('app');
            $process = new Process(['touch', $app_path.'/vm/'.$fileName]);

            $process->run();
        }

        //Populate Random Flags/Levels
        $levels = rand(5,20);

        for($i=1; $i<=$levels; $i++){
        	DB::table('lab_flags')->insert([
        		'lab_name' => $name,
        		'level' => $i,
        		'flag' => md5(Str::random(config('flag.random'))),
        		'created_at' => \Carbon\Carbon::now(),
        		'updated_at' => \Carbon\Carbon::now(),
        	]);
        }

        //Populate Hints
        for($i=1; $i<=$levels; $i++){
	        for($j=1; $j<=rand(1,3); $j++){
	        	DB::table('lab_hints')->insert([
	        		'lab_name' => $name,
	        		'level' => $i,
	        		'hint' => Str::random(50),
        			'created_at' => \Carbon\Carbon::now(),
        			'updated_at' => \Carbon\Carbon::now(),
	        	]);
	        }
    	}

    	//Randomly associate one to three skills
    	$skills = DB::table('skills')->pluck('name');
    	$skills_amt = DB::table('skills')->pluck('name')->count();

    	for($i=1; $i<=rand(1,3); $i++){
    		$skill = $skills[rand(0,$skills_amt-1)];
    		DB::table('vm_skills')->insert([
    			'vm_name' => $name,
    			'skill' =>  $skill,
        		'created_at' => \Carbon\Carbon::now(),
        		'updated_at' => \Carbon\Carbon::now(),
    		]);
    	}



    }
}
