<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHintsUsedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * Relation table linking students to hints they've used.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hints_used', function (Blueprint $table) {
            $table->string('student');
            $table->integer('hint_id')->unsigned();
            $table->string('machine_name');
            $table->foreign('machine_name')->references('name')->on('vms');
            $table->foreign('student')->references('name')->on('students');
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
        Schema::dropIfExists('hints');
    }
}
