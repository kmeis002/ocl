<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrolledTable extends Migration
{
    /**
     * Run the migrations.
     *
     * Relational table to keep track of enrolled classes for student users.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrolled', function (Blueprint $table) {
            $table->string('student');
            $table->integer('class_id')->unsigned();
            $table->foreign('student')->references('name')->on('students');
            $table->foreign('class_id')->references('id')->on('classes');
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
        Schema::dropIfExists('enrolled');
    }
}
