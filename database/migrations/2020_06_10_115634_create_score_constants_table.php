<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreConstantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * Table for scaore constants when calculating scores. 
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_constants', function (Blueprint $table) {
            $table->integer('b2r_user_weight');
            $table->integer('br2_root_weight');
            $table->integer('lab_weight');
            $table->integer('ctf_weight');
            $table->integer('b2r_hint_penalty');
            $table->integer('lab_hint_pentaly');
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
        Schema::dropIfExists('score_constants');
    }
}
