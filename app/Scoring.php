<?php
namespace App;

class Scoring
{
    const maxPoints = 100;

    public static function points(Workout $workout)
    {
        $competitors = $workout->competitors()
            ->withPivot('amount')
            ->orderBy('amount', $workout->sortOrder())
            ->get()
            ->unique('id')
            ->values();

        $amountOfCompetitors = $competitors->count();

        if ($amountOfCompetitors == 0) {
            return collect([]);
        }
        
        $differenceBetweenTwoPlaces = intval(floor(self::maxPoints / $competitors->count()));

        $scoresWithPoints = $competitors->map(function($item) use ($differenceBetweenTwoPlaces, $competitors) {

            $firstIndexWithSameScore = $competitors->search(function($otherItem) use ($item) {
                return $item->pivot->amount == $otherItem->pivot->amount;
            });

            return [
                'competitor' => $item,
                'points' => self::maxPoints - ($firstIndexWithSameScore * $differenceBetweenTwoPlaces)
            ];
        });

        return $scoresWithPoints;
    }

    public static function totalPoints($competitor)
    {
        $workouts = Workout::all();

        return $workouts->map(function($w) use ($competitor) {
            return self::pointsFromWorkout($competitor, $w);
        })->sum();
    }

    public static function pointsFromWorkout(Competitor $competitor, Workout $workout)
    {
        $allPoints = self::points($workout);

        return $allPoints->firstWhere('competitor.id', $competitor->id)['points'];
    }
}

