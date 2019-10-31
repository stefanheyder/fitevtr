<?php

use App\Workout;
use Illuminate\Database\Seeder;

class WorkoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $workouts = [
            [
                'name' => 'Reißen',
                'type' => '1RM'
            ],
            [
                'name' => 'Stoßen',
                'type' => '1RM'
            ]
        ];

        foreach ($workouts as $w)  {
            Workout::create($w);
        }
    }
}
