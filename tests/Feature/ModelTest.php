<?php

namespace Tests\Feature;

use App\Competitor;
use App\Score;
use App\Workout;
use Tests\TestCase;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModelTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateCompetitor()
    {
        $comp = factory(Competitor::class)->make();
        $comp->save();

        $this->assertDatabaseHas('competitors', ['name' => $comp->name, 'gender' => $comp->gender]);
    }

    public function testCreateWorkout()
    {
        $workout = factory(Workout::class)->make();
        $workout->save();

        $this->assertDatabaseHas('workouts', ['name' => $workout->name, 'type' => $workout->type]);
    }

    public function testCompetitorScoresWorks()
    {
        $comp = factory(Competitor::class)->make();
        $comp->save();

        $workout = factory(Workout::class)->make();
        $workout->save();

        $score = Score::create(['competitor_id' => $comp->id, 'workout_id' => $workout->id, 'amount' => 100]);

        $this->assertTrue($score->competitor->is($comp));
        $this->assertTrue($comp->scores->contains($score));
    }

    public function testWorkoutScoresWorks()
    {
        $comp = factory(Competitor::class)->make();
        $comp->save();

        $workout = factory(Workout::class)->make();
        $workout->save();

        $score = Score::create(['competitor_id' => $comp->id, 'workout_id' => $workout->id, 'amount' => 100]);

        $this->assertTrue($score->workout->is($workout));
        $this->assertTrue($workout->scores->contains($score));
    }
}
