<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabHintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * Table for machine hints.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_hints', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('lab_name');
            $table->foreign('lab_name')->references('name')->on('vms');
            $table->integer('level');
            $table->text('hint');
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
        Schema::dropIfExists('lab_hints');
    }
}
