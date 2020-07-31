<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuideSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guide_skills', function (Blueprint $table) {
            $table->id();
            $table->integer('guide_id')->unsigned();
            $table->string('skill_name');
            $table->foreign('guide_id')->references('id')->on('guides');
            $table->foreign('skill_name')->references('name')->on('skills');
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
        Schema::dropIfExists('guide_skills');
    }
}
