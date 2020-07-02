<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateB2rFlagsCompletedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b2r_flags_completed', function (Blueprint $table) {
            $table->string('student');
            $table->string('b2r_name');
            $table->boolean('user_flag');
            $table->boolean('root_flag');
            $table->foreign('student')->references('name')->on('students');
            $table->foreign('b2r_name')->references('name')->on('vms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('b2r_flags_completed');
    }
}
