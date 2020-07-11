<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCtfsAssignedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctfs_assigned', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('ctf_name')->nullable()->default(null);
            $table->foreign('ctf_name')->references('name')->on('ctfs');
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
        Schema::dropIfExists('ctfss_assigned');
    }
}
