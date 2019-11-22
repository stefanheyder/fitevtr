<?php

use Illuminate\Database\Seeder;

use App\Competition;
use App\Competitor;
use App\Flight;
use App\Team;
use App\Score;
use App\Workout;

class LandesligaBundesligaTest extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # create participants
        $sv90 = Team::create([
            'name' => 'SV 90 Gräfenroda'
        ]);
        $esvmuen = Team::create([
            'name' => 'ESV-Freimann München'
        ]);
        $esv_muehl = Team::create([
            'name' =>'ESV Mühlhausen'
        ]);

        $isLandesliga = True;

        # create snatch / c & j
        $snatch = Workout::create([
            'type' => '1RM',
            'name' => 'Reißen'
        ]);
        $cnj = Workout::create([
            'type' => '1RM',
            'name' => 'Stoßen'
        ]);
        # create competitions
        if ($isLandesliga) {
            $landesliga = Competition::create([
                'type' => 'Landesliga',
                'date' => '2019-11-23',
                'title' => 'SV90 Gräfenroda e.V. vs. ESV Mühlhausen'
            ]);

            $landesliga->workouts()->sync([$snatch->id, $cnj->id]);

            $first_comps = [
                ['name' => 'A', 'gender' => 'male', 'weight' => 100, 'sn' => 100, 'cnj' => 100],
                ['name' => 'B', 'gender' => 'male', 'weight' => 100, 'sn' => 100, 'cnj' => 100],
                ['name' => 'C', 'gender' => 'male', 'weight' => 100, 'sn' => 100, 'cnj' => 100],
                ['name' => 'D', 'gender' => 'male', 'weight' => 100, 'sn' => 100, 'cnj' => 100]
            ];
            $second_comps = [
                ['name' => 'E', 'gender' => 'male', 'weight' => 100, 'sn' => 100, 'cnj' => 100],
                ['name' => 'F', 'gender' => 'male', 'weight' => 100, 'sn' => 100, 'cnj' => 100],
                ['name' => 'G', 'gender' => 'male', 'weight' => 100, 'sn' => 100, 'cnj' => 100],
                ['name' => 'H', 'gender' => 'male', 'weight' => 100, 'sn' => 100, 'cnj' => 100]
            ];
            $team = $sv90;
            foreach ($first_comps as $info) {
                $c = Competitor::create(['name' => $info['name'], 'gender' => $info['gender'], 'team_id' => $team->id]);
                $landesliga->competitors()->attach($c, ['weight' => $info['weight']]);
                for ($i = 0; $i < 3; $i++) {
                    Score::create([
                        'amount' => $info['sn'],
                        'competitor_id' => $c->id,
                        'workout_id' => $snatch->id,
                        'validity' => 'undecided',
                        'competition_id' => $landesliga->id
                    ]);
                    Score::create([
                        'amount' => $info['cnj'],
                        'competitor_id' => $c->id,
                        'workout_id' => $cnj->id,
                        'validity' => 'undecided',
                        'competition_id' => $landesliga->id
                    ]);
                }
            }
            $team = $esv_muehl;
            foreach ($second_comps as $info) {
                $c = Competitor::create(['name' => $info['name'], 'gender' => $info['gender'], 'team_id' => $team->id]);
                $landesliga->competitors()->attach($c, ['weight' => $info['weight']]);
                for ($i = 0; $i < 3; $i++) {
                    Score::create([
                        'amount' => $info['sn'],
                        'competitor_id' => $c->id,
                        'workout_id' => $snatch->id,
                        'validity' => 'undecided',
                        'competition_id' => $landesliga->id
                    ]);
                    Score::create([
                        'amount' => $info['cnj'],
                        'competitor_id' => $c->id,
                        'workout_id' => $cnj->id,
                        'validity' => 'undecided',
                        'competition_id' => $landesliga->id
                    ]);
                }
            }
            $first_flight_ids = [1,2,5,6];
            $second_flight_ids = [3,4,7,8];

            $sn1 = Flight::create(['title' => '1. Gruppe Reißen', 'competition_id' => $landesliga->id]);
            $sn2 = Flight::create(['title' => '2. Gruppe Reißen', 'competition_id' => $landesliga->id]);
            $cnj1 = Flight::create(['title' => '1. Gruppe Stoßen', 'competition_id' => $landesliga->id]);
            $cnj2 = Flight::create(['title' => '2. Gruppe Stoßen', 'competition_id' => $landesliga->id]);
            $all = Flight::create(['title' => 'Alle', 'competition_id' => $landesliga->id]);

            $sn1->competitors()->sync($first_flight_ids);
            $sn1->workouts()->sync([$snatch->id]);

            $sn2->competitors()->sync($second_flight_ids);
            $sn2->workouts()->sync([$snatch->id]);

            $cnj1->competitors()->sync($first_flight_ids);
            $cnj1->workouts()->sync([$cnj->id]);

            $cnj2->competitors()->sync($second_flight_ids);
            $cnj2->workouts()->sync([$cnj->id]);

            $all->competitors()->sync(Competitor::all());
            $all->workouts()->sync(Workout::all());

        } else {
            $bundesliga = Competition::create([
                'type' => 'Bundesliga',
                'date' => '2019-11-23',
                'title' => 'SV90 Gräfenroda e.V. vs. ESV Freimann München'
            ]);

        }
        # create dummy athletes

    }
}
