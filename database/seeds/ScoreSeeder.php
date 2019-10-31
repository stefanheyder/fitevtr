<?php

use App\Score;
use App\Competitor;
use App\Workout;
use App\Flight;
use Illuminate\Database\Seeder;

class ScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $scores = [
            ["competitor_id" => 1, "workout_id" => 1, "amount" => 80, "validity" => "valid"],
            ["competitor_id" => 1, "workout_id" => 1, "amount" => 85, "validity" => "valid"],
            ["competitor_id" => 1, "workout_id" => 1, "amount" => 90, "validity" => "valid"],

            ["competitor_id" => 1, "workout_id" => 2, "amount" => 100, "validity" => "valid"],
            ["competitor_id" => 1, "workout_id" => 2, "amount" => 110, "validity" => "valid"],
            #["competitor_id" => 1, "workout_id" => 2, "amount" => 115, "validity" => "valid"],

            ["competitor_id" => 2, "workout_id" => 1, "amount" => 47, "validity" => "valid"],
            ["competitor_id" => 2, "workout_id" => 1, "amount" => 50, "validity" => "valid"],
            ["competitor_id" => 2, "workout_id" => 1, "amount" => 53, "validity" => "invalid"],

            ["competitor_id" => 2, "workout_id" => 2, "amount" => 65, "validity" => "valid"],
            ["competitor_id" => 2, "workout_id" => 2, "amount" => 68, "validity" => "valid"],
            ["competitor_id" => 2, "workout_id" => 2, "amount" => 70, "validity" => "valid"],

            ["competitor_id" => 3, "workout_id" => 1, "amount" => 55, "validity" => "valid"],
            ["competitor_id" => 3, "workout_id" => 1, "amount" => 60, "validity" => "valid"],
            ["competitor_id" => 3, "workout_id" => 1, "amount" => 65, "validity" => "valid"],

            ["competitor_id" => 3, "workout_id" => 2, "amount" => 70, "validity" => "valid"],
            ["competitor_id" => 3, "workout_id" => 2, "amount" => 75, "validity" => "valid"],
            ["competitor_id" => 3, "workout_id" => 2, "amount" => 78, "validity" => "valid"],

            ["competitor_id" => 4, "workout_id" => 1, "amount" => 70, "validity" => "valid"],
            ["competitor_id" => 4, "workout_id" => 1, "amount" => 75, "validity" => "valid"],
            ["competitor_id" => 4, "workout_id" => 1, "amount" => 78, "validity" => "valid"],

            ["competitor_id" => 4, "workout_id" => 2, "amount" => 90, "validity" => "valid"],
            ["competitor_id" => 4, "workout_id" => 2, "amount" => 95, "validity" => "valid"],
            ["competitor_id" => 4, "workout_id" => 2, "amount" => 100, "validity" => "valid"],

            ["competitor_id" => 5, "workout_id" => 1, "amount" => 51, "validity" => "valid"],
            ["competitor_id" => 5, "workout_id" => 1, "amount" => 54, "validity" => "valid"],
            ["competitor_id" => 5, "workout_id" => 1, "amount" => 56, "validity" => "invalid"],

            ["competitor_id" => 5, "workout_id" => 2, "amount" => 62, "validity" => "valid"],
            ["competitor_id" => 5, "workout_id" => 2, "amount" => 66, "validity" => "invalid"],
            ["competitor_id" => 5, "workout_id" => 2, "amount" => 66, "validity" => "valid"],

            ["competitor_id" => 6, "workout_id" => 1, "amount" => 40, "validity" => "valid"],
            ["competitor_id" => 6, "workout_id" => 1, "amount" => 42, "validity" => "valid"],
            ["competitor_id" => 6, "workout_id" => 1, "amount" => 43, "validity" => "valid"],

            ["competitor_id" => 6, "workout_id" => 2, "amount" => 52, "validity" => "valid"],
            ["competitor_id" => 6, "workout_id" => 2, "amount" => 54, "validity" => "valid"],
            ["competitor_id" => 6, "workout_id" => 2, "amount" => 56, "validity" => "valid"],

            ["competitor_id" => 7, "workout_id" => 1, "amount" => 100, "validity" => "valid"],
            ["competitor_id" => 7, "workout_id" => 1, "amount" => 105, "validity" => "valid"],
            ["competitor_id" => 7, "workout_id" => 1, "amount" => 109, "validity" => "valid"],

            ["competitor_id" => 7, "workout_id" => 2, "amount" => 123, "validity" => "valid"],
            ["competitor_id" => 7, "workout_id" => 2, "amount" => 128, "validity" => "valid"],
            ["competitor_id" => 7, "workout_id" => 2, "amount" => 132, "validity" => "valid"],

            ["competitor_id" => 8, "workout_id" => 1, "amount" => 85, "validity" => "valid"],
            ["competitor_id" => 8, "workout_id" => 1, "amount" => 90, "validity" => "valid"],
            ["competitor_id" => 8, "workout_id" => 1, "amount" => 93, "validity" => "valid"],

            ["competitor_id" => 8, "workout_id" => 2, "amount" => 110, "validity" => "valid"],
            ["competitor_id" => 8, "workout_id" => 2, "amount" => 115, "validity" => "valid"],
            ["competitor_id" => 8, "workout_id" => 2, "amount" => 120, "validity" => "invalid"],

            ["competitor_id" => 9, "workout_id" => 1, "amount" => 84, "validity" => "valid"],
            ["competitor_id" => 9, "workout_id" => 1, "amount" => 87, "validity" => "valid"],
            ["competitor_id" => 9, "workout_id" => 1, "amount" => 90, "validity" => "valid"],

            ["competitor_id" => 9, "workout_id" => 2, "amount" => 120, "validity" => "invalid"],
            ["competitor_id" => 9, "workout_id" => 2, "amount" => 120, "validity" => "valid"],
            ["competitor_id" => 9, "workout_id" => 2, "amount" => 123, "validity" => "valid"],

            ["competitor_id" => 10, "workout_id" => 1, "amount" => 85, "validity" => "valid"],
            ["competitor_id" => 10, "workout_id" => 1, "amount" => 90, "validity" => "valid"],
            ["competitor_id" => 10, "workout_id" => 1, "amount" => 95, "validity" => "valid"],

            ["competitor_id" => 10, "workout_id" => 2, "amount" => 110, "validity" => "valid"],
            ["competitor_id" => 10, "workout_id" => 2, "amount" => 120, "validity" => "valid"],
            ["competitor_id" => 10, "workout_id" => 2, "amount" => 125, "validity" => "valid"],

            ["competitor_id" => 11, "workout_id" => 1, "amount" => 47, "validity" => "valid"],
            ["competitor_id" => 11, "workout_id" => 1, "amount" => 51, "validity" => "valid"],
            ["competitor_id" => 11, "workout_id" => 1, "amount" => 54, "validity" => "valid"],

            ["competitor_id" => 11, "workout_id" => 2, "amount" => 60, "validity" => "valid"],
            ["competitor_id" => 11, "workout_id" => 2, "amount" => 63, "validity" => "valid"],
            ["competitor_id" => 11, "workout_id" => 2, "amount" => 65, "validity" => "invalid"],

            ["competitor_id" => 12, "workout_id" => 1, "amount" => 47, "validity" => "valid"],
            ["competitor_id" => 12, "workout_id" => 1, "amount" => 50, "validity" => "valid"],
            ["competitor_id" => 12, "workout_id" => 1, "amount" => 52, "validity" => "invalid"],

            ["competitor_id" => 12, "workout_id" => 2, "amount" => 62, "validity" => "valid"],
            ["competitor_id" => 12, "workout_id" => 2, "amount" => 66, "validity" => "valid"],
            ["competitor_id" => 12, "workout_id" => 2, "amount" => 70, "validity" => "invalid"]
        ];

        foreach ($scores as $score) {
            App\Score::create($score);
        }

    }
}
