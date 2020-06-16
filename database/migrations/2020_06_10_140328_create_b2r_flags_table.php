<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateB2RFlagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b2r_flags', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('b2r_name');
            $table->foreign('b2r_name')->references('name')->on('vms');
            $table->string('root_flag');
            $table->string('user_flag');
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
        Schema::dropIfExists('root_flags');
    }
}
