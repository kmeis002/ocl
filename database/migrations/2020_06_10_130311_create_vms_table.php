<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('points')->unsigned();
            $table->string('file')->nullable();
            $table->string('ip');
            $table->unique(array('name','ip', 'file'));
            $table->string('os');
            $table->string('icon');
            $table->text('description')->nullable();
            $table->boolean('status');
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
        Schema::dropIfExists('vms');
    }
}
