<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateB2rsAssignedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b2rs_assigned', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('b2r_name')->nullable()->default(null);
            $table->foreign('b2r_name')->references('name')->on('vms');
            $table->boolean('user')->default(true);
            $table->boolean('root')->default(true);
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
        Schema::dropIfExists('b2rs_assigned');
    }
}
