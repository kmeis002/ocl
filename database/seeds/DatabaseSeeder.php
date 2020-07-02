<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SkillSeeder::class);

        for($i=0; $i<=30; $i++){
        	$this->call(LabSeeder::class);
        	$this->call(B2RSeeder::class);

        }

        for($i=0; $i<=50; $i++){
            $this->call(CTFSeeder::class);
        }
    }
}
