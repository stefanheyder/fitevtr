<?php
namespace App;

use App\Competitor;
use App\Flight;

class Scoring
{
    const maxPoints = 100;

    const wilks_poly_coeffs = [
        "male" => [
            -216.0475144,
            16.2606339,
            -0.002388645,
            -0.00113732,
            7.01863E-06,
            -1.291E-08
        ],
        "female" => [
            594.31747775582,
            -27.23842536447,
            0.82112226871,
            -0.00930733913,
            4.731582E-05,
            -9.054E-08
        ]
    ];

    const sinclair_constants = [
        "male" => [
            "A" => 0.751945030,
            "b" => 175.508
        ],
        "female" => [
            "A" => 0.783497476,
            "b" => 153.655
        ]
    ];

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

    public static function wilksPoints(Competitor $competitor, Flight $flight)
    {
        $wilks_coefficient = self::wilksCoeff($competitor->weight, $competitor->gender);

        return $competitor->powerliftingTotal($flight) * $wilks_coefficient;
    }

    public static function wilksCoeff($weight, $gender)
    {
        $w = $weight;

        $c = self::wilks_poly_coeffs[$gender];

        $poly = $c[0] +
            $c[1] * $w +
            $c[2] * ($w ** 2) +
            $c[3] * ($w ** 3) +
            $c[4] * ($w ** 4) +
            $c[5] * ($w ** 5);

        return 500 / $poly;
    }

    public static function sinclairPoints(Competitor $competitor, Flight $flight)
    {
        $sinclair_coefficient = self::sinclairCoeff($competitor->weight, $competitor->gender);

        return $competitor->powerliftingTotal($flight) * $sinclair_coefficient;
    }

    public static function sinclairCoeff($weight, $gender)
    {
        $A = self::sinclair_constants[$gender]["A"];
        $b = self::sinclair_constants[$gender]["b"];

        return pow(10, $A * pow((log(min($weight / $b, 1), 10)), 2));
    }

}

