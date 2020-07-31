<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferenceSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reference_sections', function (Blueprint $table) {
            $table->id();
            $table->integer('references_id')->unsigned();
            $table->string('name');
            $table->longText('content');
            $table->foreign('references_id')->references('id')->on('refs');
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
        Schema::dropIfExists('reference_sections');
    }
}
