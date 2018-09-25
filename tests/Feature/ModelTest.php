<?php

namespace Tests\Feature;

use App\Competitor;
use App\Score;
use App\Workout;
use Tests\TestCase;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Throwable;

class ModelTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateCompetitor()
    {
        $comp = factory(Competitor::class)->create();

        $this->assertDatabaseHas('competitors', ['name' => $comp->name, 'gender' => $comp->gender]);
    }

    public function testCreateWorkout()
    {
        $workout = factory(Workout::class)->create();

        $this->assertDatabaseHas('workouts', ['name' => $workout->name, 'type' => $workout->type]);
    }

    public function testCompetitorScoresWorks()
    {
        $comp = factory(Competitor::class)->create();

        $workout = factory(Workout::class)->create();

        $score = Score::create(['competitor_id' => $comp->id, 'workout_id' => $workout->id, 'amount' => 100]);

        $this->assertTrue($score->competitor->is($comp));
        $this->assertTrue($comp->scores->contains($score));
    }

    public function testWorkoutScoresWorks()
    {
        $comp = factory(Competitor::class)->create();

        $workout = factory(Workout::class)->create();

        $score = Score::create(['competitor_id' => $comp->id, 'workout_id' => $workout->id, 'amount' => 100]);

        $this->assertTrue($score->workout->is($workout));
        $this->assertTrue($workout->scores->contains($score));
    }

    public function testCanCreateCompetitorViaWeb()
    {
        $comp = factory(Competitor::class)->make();

        $this->post('/competitor', $comp->attributesToArray());
        $this->assertDatabaseHas('competitors', $comp->attributesToArray());
    }

    public function testCanAccessScoresOfAWorkout()
    {
        $comp = factory(Competitor::class)->create();
        $work = factory(Workout::class)->create();

        $scores = factory(Score::class, 10)->create([ 'competitor_id' => $comp->id, 'workout_id' => $work->id]);

        $this->assertSameSize($scores, $comp->scoresInWorkout($work)->get());
    }

    public function testWillAccessHighestScore()
    {
        $comp = factory(Competitor::class)->create();
        $work = factory(Workout::class)->create();

        $scores = factory(Score::class, 10)->create([ 'competitor_id' => $comp->id, 'workout_id' => $work->id]);

        $this->assertEquals($scores->max('amount'), $comp->bestScore($work));
    }

    public function testWillReturnZeroIfNoScoresWerePosted()
    {
        $comp = factory(Competitor::class)->create();
        $work = factory(Workout::class)->create();

        $this->assertEquals(1, $comp->bestScore($work));
    }

}
