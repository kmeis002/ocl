<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabsAssignedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labs_assigned', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('lab_name')->nullable()->default(null);
            $table->foreign('lab_name')->references('name')->on('vms');
            $table->integer('start_level')->default(0);
            $table->integer('end_level')->default(0);
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
        Schema::dropIfExists('labs_assigned');
    }
}
