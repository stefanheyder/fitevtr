<?php

use App\Competitor;
use App\Flight;
use App\Workout;
use Illuminate\Database\Seeder;

class CompetitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $competitors = [
            # Schwarza
            ["name" => "Alexander Meinhardt-Heib", "gender" => "male", "weight" => 101.2],
            ["name" => "Lisa Möller", "gender" => "female", "weight" => 73.7],
            ["name" => "Max Nessen", "gender" => "male", "weight" => 75.3],
            ["name" => "Jakob Nikolaschin", "gender" => "male", "weight" => 94.2],
            # AK Schwaza
            ["name" => "Saskia Brummer", "gender" => "female", "weight" => 65.1],
            ["name" => "Heide Schubert", "gender" => "female", "weight" => 63.5],
            # GFR
            ["name" => "Richard Hendrich", "gender" => "male", "weight" => 116],
            ["name" => "Nico Holtmann", "gender" => "male", "weight" => 77],
            ["name" => "Sebastian Semper", "gender" => "male", "weight" => 91.9],
            ["name" => "Philipp Schreck", "gender" => "male", "weight" => 93.8],
            # AK GFR
            ["name" => "Diana Kurbanova", "gender" => "female", "weight" => 68.1],
            ["name" => "Raphael Kleinfeldt", "gender" => "male", "weight" => 66.6]
        ];

        foreach($competitors as $competitor) {
            Competitor::create($competitor);
        }

        $flightNames = [
            ["title" => "Alle Heber"],
            ["title" => "SV Schwarza"],
            ["title" => "SV Schwarza a.K."],
            ["title" => "SV 90 Gräfenroda"],
            ["title" => "SV 90 Gräfenroda a.K."]
        ];

        foreach($flightNames as $flight) {
            Flight::create($flight);
        }

        $all = Flight::first();

        $all->competitors()->sync(Competitor::all());
        $all->workouts()->sync(Workout::all());
    }
}
