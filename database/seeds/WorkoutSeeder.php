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
                'name' => 'Squat', 
                'type' => '1RM'
            ],
            [ 
                'name' => 'Bench Press', 
                'type' => '1RM'
            ],
            [ 
                'name' => 'Deadlift', 
                'type' => '1RM'
            ]
        ];

        foreach ($workouts as $w)  {
            Workout::create($w);
        }
    }
}
