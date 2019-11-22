<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddScore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('competition_id')->references('id')->on('competitions');
            $table->integer('competitor_id')->references('id')->on('competitors');
            $table->integer('workout_id')->references('id')->on('workouts');
            $table->float('amount');

            $table->enum('validity', ['valid', 'undecided', 'invalid'])->default('undecided');

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
        Schema::dropIfExists('score');
    }
}
