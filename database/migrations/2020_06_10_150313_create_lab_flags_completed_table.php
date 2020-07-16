<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabFlagsCompletedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_flags_completed', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('student');
            $table->string('lab_name');
            $table->integer('level');   //
            $table->foreign('student')->references('name')->on('students');
            $table->foreign('lab_name')->references('name')->on('vms');
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
        Schema::dropIfExists('lab_flags_completed');
    }
}