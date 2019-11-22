<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Competition;

class CreateCompetitonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->enum('type', Competition::TYPES);
            $table->date('date');
            $table->string('title');
        });

        Schema::create('competition_workout', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('competition_id')->references('id')->on('competitions');
            $table->integer('workout_id')->references('id')->on('workouts');
        });
        Schema::create('competition_competitor', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->float('weight');
            $table->boolean('competitive')->default(True);

            $table->integer('competition_id')->references('id')->on('competitions');
            $table->integer('competitor_id')->references('id')->on('competitors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competition_competitor');
        Schema::dropIfExists('competition_workout');
        Schema::dropIfExists('competitions');
    }
}
