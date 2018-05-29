<?php

use App\Workout;
use App\Competitor;
use Faker\Generator as Faker;

$factory->define(App\Score::class, function (Faker $faker) {

    $workout = Workout::query()->inRandomOrder()->first();
    $competitor = Competitor::query()->inRandomOrder()->first();

    return [
        'score' => $faker->numberBetween(100,400),
        'workout_id' => $workout->id,
        'competitor_id' => $competitor->id
    ];
});
