<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCtfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctfs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('icon');
            $table->string('file')->nullable();
            $table->integer('points');
            $table->string('category');
            $table->text('description')->nullable();
            $table->string('flag');
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
        Schema::dropIfExists('ctfs');
    }
}
