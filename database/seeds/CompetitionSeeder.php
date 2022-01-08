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
            'title' => 'Test Wettkampf SLZ',
            'type' => 'Landesliga',
            'date' => '2020-09-05'
        ])
    }
}
