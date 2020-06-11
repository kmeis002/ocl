<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCtfsCompletedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctfs_completed', function (Blueprint $table) {
            $table->string('student');
            $table->string('ctf_name');
            $table->foreign('student')->references('name')->on('students');
            $table->foreign('ctf_name')->references('name')->on('ctfs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ctfs_completed');
    }
}
