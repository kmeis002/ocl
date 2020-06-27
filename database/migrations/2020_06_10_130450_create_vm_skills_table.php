<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVmSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * Relational table linking vm's to skills (need to make Skill_List_Items for many-to-many relations)
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vm_skills', function (Blueprint $table) {
            $table->string('vm_name');
            $table->string('skill');
            $table->foreign('vm_name')->references('name')->on('vms');
            $table->foreign('skill')->references('name')->on('skills');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vm_skills');
    }
}
