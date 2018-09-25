<?php

use App\Score;
use App\Competitor;
use App\Workout;
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
        foreach(Competitor::all() as $c) {
            foreach(Workout::all() as $w) {
                factory(App\Score::class, 1)->create([
                    'competitor_id' => $c->id,
                    'workout_id' => $w->id,
                ]);
            }
        }
    }
}
