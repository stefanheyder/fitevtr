<?php

use App\Competitor;
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
        Competitor::create(['name' => 'David Zilles', 'gender' => 'male']);
        Competitor::create(['name' => 'Saskia Widdison', 'gender' => 'female']);
        Competitor::create(['name' => 'Kim Frerichs', 'gender' => 'female']);
        Competitor::create(['name' => 'Jan-Cedric Vogt', 'gender' => 'male']);
    }
}
