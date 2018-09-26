<?php

use App\Competitor;
use App\Flight;
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
        $competitors = factory(App\Competitor::class, 10)->create();

        $firstFlight = new Flight(['title' => 'Frauen']);
        $firstFlight->save();

        $secondFlight = new Flight(['title' => 'Herren']);
        $secondFlight->save();

        $firstFlight->competitors()->attach($competitors->take(5));
        $secondFlight->competitors()->attach($competitors->take(-5));

        $firstFlight->save();
        $secondFlight->save();
    }
}
