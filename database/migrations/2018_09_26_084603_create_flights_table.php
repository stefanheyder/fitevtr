<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
            $table->integer('competition_id')->references('id')->on('competitions');
        });

        Schema::create('competitor_flight', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('competitor_id')->references('id')->on('competitors');
            $table->integer('flight_id')->references('id')->on('flights');
            $table->timestamps();
        });

        Schema::create('flight_workout', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('workout_id')->references('id')->on('workout');
            $table->integer('flight_id')->references('id')->on('flights');
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
        Schema::dropIfExists('flights');
        Schema::dropIfExists('competitor_flight');
        Schema::dropIfExists('flight_workout');
    }
}
