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
                'name' => 'Kniebeuge', 
                'type' => '1RM'
            ],
            [ 
                'name' => 'Bankdrücken', 
                'type' => '1RM'
            ],
            [ 
                'name' => 'Kniebeuge (EQ)', 
                'type' => '1RM'
            ],
            [ 
                'name' => 'Bankdrücken (EQ)', 
                'type' => '1RM'
            ]
        ];

        foreach ($workouts as $w)  {
            Workout::create($w);
        }
    }
}
