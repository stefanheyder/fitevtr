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
                'name' => 'Deadlift & Burpees', 
                'type' => 'AMRAP'
            ],
            [ 
                'name' => 'Squats & Laufen', 
                'type' => 'ForTime'
            ],
            [ 
                'name' => 'KBS & PushUps', 
                'type' => 'ForTime'
            ],
            [ 
                'name' => 'Deadlift', 
                'type' => '1RM'
            ],
            [ 
                'name' => 'Ground To Overhead', 
                'type' => '1RM'
            ]
        ];
        foreach ($workouts as $w)  {
            Workout::create($w);
        }
    }
}
