<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeVmTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * Relational table for linking vms to their requisite types.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vm_type', function (Blueprint $table) {
            $table->string('vm_name');
            $table->string('type_name');
            $table->foreign('vm_name')->references('name')->on('vms');
            $table->foreign('type_name')->references('name')->on('types');
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
        Schema::dropIfExists('vm_type');
    }
}
