<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferenceSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reference_skills', function (Blueprint $table) {
            $table->id();
            $table->integer('reference_id')->unsigned();
            $table->string('skill_name');
            $table->foreign('reference_id')->references('id')->on('refs');
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
        Schema::dropIfExists('reference_skills');
    }
}
