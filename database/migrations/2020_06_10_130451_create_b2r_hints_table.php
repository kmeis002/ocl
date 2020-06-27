<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateB2RHintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b2r_hints', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('b2r_name');
            $table->foreign('b2r_name')->references('name')->on('vms');
            $table->boolean('is_root');
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
        Schema::dropIfExists('b2r_hints');
    }
}
