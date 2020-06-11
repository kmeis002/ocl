<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVmsCompletedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vms_completed', function (Blueprint $table) {
            $table->string('student');
            $table->string('vm_name');
            $table->foreign('student')->references('name')->on('students');
            $table->foreign('vm_name')->references('name')->on('vms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vms_completed');
    }
}
