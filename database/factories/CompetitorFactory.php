<?php

use Faker\Generator as Faker;

$factory->define(App\Competitor::class, function (Faker $faker) {
    $gender = $faker->randomElement([ 'male', 'female' ]);
    return [
        'name' => $faker->name($gender),
        'weight' => $faker->randomFloat(4, 60, 120),
        'gender' => $gender
    ];
});
