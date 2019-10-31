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

        Schema::create('competition_participant', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('competiton_id')->references('id')->on('competitions');
            $table->integer('participant_id')->references('id')->on('participants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competitions');
        Schema::dropIfExists('competition_participant');
    }
}
