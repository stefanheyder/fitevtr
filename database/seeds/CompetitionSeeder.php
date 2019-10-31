<?php

use Illuminate\Database\Seeder;

use App\Competition;

class CompetiitonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Compeition::create([
            'title' => 'SV 90 Gräfenroda vs. AC Suhl',
            'type' => 'Landesliga',
            'date' => '2019-11-26'
        ])
    }
}
