<?php

use App\Workout;
use App\Competitor;
use Faker\Generator as Faker;

$factory->define(App\Score::class, function (Faker $faker) {

    $workout = Workout::query()->inRandomOrder()->first();
    $competitor = Competitor::query()->inRandomOrder()->first();

    return [
        'amount' => $faker->numberBetween(500, 1000) / 4,
        'workout_id' => $workout->id,
        'competitor_id' => $competitor->id,
        'validity' => $faker->randomElement(['valid', 'undecided', 'invalid'])
    ];
});
