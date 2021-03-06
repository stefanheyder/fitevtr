<?php

use App\Workout;
use Faker\Generator as Faker;


$factory->define(App\Workout::class, function (Faker $faker) {
    $type = $faker->randomElement(Workout::TYPES);

    $amountOfEx = 1;
    $exercises = $faker->randomElements([
            'Burpees',
            'KettleBell Swings',
            'Deadlifts',
            'Squats',
            'PushUps',
            'Run',
            'Clean & Jerk'
        ], $amountOfEx, true);

    return [
        'type' => $type,
        'name' => implode(', ', $exercises)
    ];
});
