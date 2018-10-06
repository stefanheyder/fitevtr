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
            ["name" => "Dirck Wetzel", "gender" => "male"],
            ["name" => "Leonid Hanez", "gender" => "male"],
            ["name" => "Alexander Matsch", "gender" => "male"],
            ["name" => "Bernd Beyer", "gender" => "male"],
            ["name" => "Uwe  Billig", "gender" => "male"],
            ["name" => "Tobias Zinserling", "gender" => "male"],
            ["name" => "Jens Wagner", "gender" => "male"],
            ["name" => "Caroline Kupfer", "gender" => "female"],
            ["name" => "Ramon Baubel", "gender" => "male"],
            ["name" => "Christopher Großkurth", "gender" => "male"],
            ["name" => "Carola Herzog", "gender" => "female"],
            ["name" => "Nadin Elfenbein", "gender" => "female"],
            ["name" => "Malte Siefarth", "gender" => "male"],
            ["name" => "Christina Büller", "gender" => "female"],
            ["name" => "Sebastian Semper", "gender" => "male"],
            ["name" => "Constantin  Ritzmann", "gender" => "male"],
            ["name" => "Marcus Siegmund ", "gender" => "male"],
            ["name" => "Fernando Hillebrand", "gender" => "male"],
            ["name" => "Kim Frerichs", "gender" => "female"],
            ["name" => "Steffen Koch", "gender" => "male"],
            ["name" => "Anne Schmidt", "gender" => "female"],
            ["name" => "Patric Gregor", "gender" => "male"],
            ["name" => "Lucas Weidich", "gender" => "male"],
            ["name" => "Jose Ivan Gonzales Abad", "gender" => "male"],
            ["name" => "Lukas Weidich", "gender" => "male"],
            ["name" => "Paul Schleicher", "gender" => "male"],
            ["name" => "Markus Hake", "gender" => "male"],
            ["name" => "Oliver Berger", "gender" => "male"],
            ["name" => "Ronny Kreitl", "gender" => "male"],
            ["name" => "Mathias Keimling", "gender" => "male"],
            ["name" => "Christian  Wolf", "gender" => "male"],
            ["name" => "Benjamin Heidebrunn", "gender" => "male"],
            ["name" => "Christoph  Koch", "gender" => "male"],
            ["name" => "Alexander Jung", "gender" => "male"],
            ["name" => "Patrick Wirth", "gender" => "male"],
            ["name" => "Felix Blaurock", "gender" => "male"],
            ["name" => "Tina Asmus", "gender" => "female"],
            ["name" => "Marco Schülke", "gender" => "male"]
        ];

        foreach($competitors as $competitor) {
            Competitor::create($competitor);
        }

        $flightNames = [
            ["title" => "All"],
            ["title" => "Flight 1A"],
            ["title" => "Flight 1B"],
            ["title" => "Flight 2A"],
            ["title" => "Flight 2B"],
            ["title" => "Squat (RAW + EQ)"],
            ["title" => "Bench (RAW + EQ)"],
            ["title" => "RAW"],
            ["title" => "EQ"]
        ];

        foreach($flightNames as $flight) {
            Flight::create($flight);
        }

        $all = Flight::first();

        $all->competitors()->sync(Competitor::all());
        $all->workouts()->sync(Workout::all());
    }
}
