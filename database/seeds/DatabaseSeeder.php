<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        #$this->call(WorkoutSeeder::class);
        #$this->call(CompetitorSeeder::class);
        #$this->call(ScoreSeeder::class);
        #$this->call(UserSeeder::class);
        $this->call(LandesligaBundesligaTest::class);
    }
}
