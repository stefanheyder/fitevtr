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

    const relative_deductions = [
        "male" => [
            22.5, 23.0, 23.5, 24.0, 24.5, 25.0, 25.5, 26.0, 26.5, 27.0,
            27.5, 28.0, 28.5, 29.0, 29.5, 30.0, 30.5, 31.0, 32.0, 33.0,
            34.5, 36.0, 37.0, 38.5, 40.0, 42.0, 44.0, 46.0, 48.0, 50.0,
            52.0, 54.0, 56.0, 57.5, 59.0, 60.5, 62.0, 63.5, 65.0, 66.5,
            68.0, 69.5, 70.5, 70.5, 71.5, 72.5, 74.0, 75.5, 77.0, 78.0,
            80.0, 81.0, 82.0, 83.0, 84.0, 85.0, 86.0, 87.0, 88.0, 90.0,
            91.0, 92.0, 93.0, 94.0, 95.0, 95.5, 96.0, 96.5, 97.0, 97.5,
            98.5, 99.5,100.5,101.0,102.0,103.0,103.5,103.5,103.0,104.0,
            104.0,104.5,104.5,105.0,105.0,105.5,106.0,106.5,107.0,107.5,
            108.0,108.5,109.0,109.5,110.0,110.5,111.0,111.5,112.0,112.5,
            113.0,113.5,114.0,114.5,115.0,115.5,116.0,116.5,117.0,117.5,
            118.0,118.5,119.0,119.5,120.0,120.5,121.0,121.5,122.0,122.5,
            123.0,123.5,124.0,124.5,125.0,125.5,126.0,126.5,127.0,127.5
        ],
        "female" => [
            12.5, 12.5, 12.5, 12.5, 12.5, 12.5, 12.5, 12.5, 12.5, 12.5,
            13.0, 13.0, 13.5, 13.5, 14.0, 14.0, 14.5, 15.0, 15.5, 16.0,
            16.5, 17.0, 17.5, 18.5, 19.5, 20.5, 21.5, 22.5, 23.5, 25.0,
            26.5, 27.5, 28.5, 29.5, 31.0, 32.0, 33.0, 34.0, 35.0, 36.0,
            37.0, 38.0, 39.0, 39.5, 40.0, 40.5, 41.0, 41.5, 42.0, 42.5,
            43.0, 43.5, 44.0, 44.5, 44.5, 45.0, 45.5, 46.0, 46.0, 46.5,
            47.0, 47.5, 47.5, 48.0, 48.5, 48.5, 49.0, 49.5, 49.5, 50.0,
            50.5, 50.5, 51.0, 51.0, 51.5, 51.5, 52.0, 52.0, 52.5, 52.5,
            53.0, 53.0, 53.5, 53.5, 53.0, 53.0, 54.5, 54.5, 55.0, 55.0,
            55.5, 55.5, 56.0, 56.0, 56.5, 56.5, 57.0, 57.0, 57.5, 57.5,
            58.0, 58.0, 58.5, 58.5, 59.0, 59.0, 59.5, 59.5, 60.0, 60.0,
            60.5, 60.5, 61.0, 61.0, 61.5, 61.5, 62.0, 62.0, 62.5, 62.5,
            63.0, 63.0, 63.5, 63.5, 64.0, 64.0, 64.5, 64.5, 65.0, 65.0
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

    public static function relative_deduction($weight, $gender)
    {
        $w_ceiling = ceil($weight);
        return self::relative_deductions[$gender][$w_ceiling - 31];
    }
}

