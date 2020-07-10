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

        for($i=0; $i<=10; $i++){
        	$this->call(LabSeeder::class);
        	$this->call(B2RSeeder::class);

        }

        for($i=0; $i<=10; $i++){
            $this->call(CTFSeeder::class);
        }

        $this->call(TeacherSeeder::class);
        $this->call(StudentSeeder::class);

        $this->call(CourseSeeder::class);
        $this->call(ClassSeeder::class);
        $this->call(EnrolledSeeder::class);

    }
}
