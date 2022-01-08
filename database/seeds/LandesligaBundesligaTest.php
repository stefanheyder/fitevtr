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
            'name' => 'SV90 Gräfenroda',
            'shorthand' => 'SV90'
        ]);
        $esvmuen = Team::create([
            'name' => 'ESV-München Freimann',
            'shorthand' => 'ESV-M F'
        ]);
        $esv_muehl = Team::create([
            'name' =>'ESV Lok Mühlhausen',
            'shorthand' => 'ESV-M'
        ]);

        $others = Team::create([
            'name' => 'AC Suhl / ASV Herbsleben',
            'shorthand' => 'AC / ASV'
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
                'title' => 'Landesliga Testwettkampf'
            ]);

            $landesliga->workouts()->sync([$snatch->id, $cnj->id]);

            $first_comps = [
                ['gender' => 'male', 'weight' => 71.6, 'sn' => 50, 'cnj' => 70, 'competitive' => true, 'name' => 'Raphael Kleinfeld'],
                ['gender' => 'male', 'weight' => 54.7, 'sn' => 47, 'cnj' => 60, 'competitive' => true, 'name' => 'Marc Pfeiffer'],
                ['gender' => 'male', 'weight' => 59.8, 'sn' => 37, 'cnj' => 50, 'competitive' => true, 'name' => 'Nils Gürth'],
                ['gender' => 'male', 'weight' => 95.8, 'sn' => 120, 'cnj' => 150, 'competitive' => true, 'name' => 'Andre Langkable'],
                ['gender' => 'male', 'weight' => 67.5, 'sn' => 60, 'cnj' => 80, 'competitive' => false, 'name' => 'Jonas Wahl']
            ];
            $second_comps = [
                ['gender' => 'male', 'weight' => 58.6, 'sn' => 38, 'cnj' => 45, 'competitive' => true, 'name' => 'Jeremy Goethe'],
                ['gender' => 'male', 'weight' => 53.4, 'sn' => 23, 'cnj' => 30, 'competitive' => true, 'name' => 'Henry Messing'],
                ['gender' => 'male', 'weight' => 40.5, 'sn' => 25, 'cnj' => 33, 'competitive' => true, 'name' => 'Melving Mühlbach'],
                ['gender' => 'male', 'weight' => 160.4, 'sn' => 85, 'cnj' => 100, 'competitive' => true, 'name' => 'Alexander Hohn'],
                ['gender' => 'male', 'weight' => 124.1, 'sn' => 80, 'cnj' => 100, 'competitive' => true, 'name' => 'Marlon Jahn']
            ];
            $first_flight_ids = [1,2,3,6,7,8];
            $second_flight_ids = [4,5,9,10];
            $team = $sv90;
            foreach ($first_comps as $info) {
                $c = Competitor::create(['name' => $info['name'], 'gender' => $info['gender'], 'team_id' => $team->id]);
                $landesliga->competitors()->attach($c, ['weight' => $info['weight'], 'competitive' => $info['competitive']]);
                for ($i = 0; $i < 3; $i++) {
                    if ($info['sn'] > 0) {
                        Score::create([
                            'amount' => $info['sn'],
                            'competitor_id' => $c->id,
                            'workout_id' => $snatch->id,
                            'validity' => 'undecided',
                            'competition_id' => $landesliga->id
                        ]);
                    }
                    if ($info['cnj'] > 0) {
                        Score::create([
                            'amount' => $info['cnj'],
                            'competitor_id' => $c->id,
                            'workout_id' => $cnj->id,
                            'validity' => 'undecided',
                            'competition_id' => $landesliga->id
                        ]);
                    }
                }
            }
            $team = $others;
            foreach ($second_comps as $info) {
                $c = Competitor::create(['name' => $info['name'], 'gender' => $info['gender'], 'team_id' => $team->id]);
                $landesliga->competitors()->attach($c, ['weight' => $info['weight']]);
                for ($i = 0; $i < 3; $i++) {
                    if ($info['sn'] > 0) {
                        Score::create([
                            'amount' => $info['sn'],
                            'competitor_id' => $c->id,
                            'workout_id' => $snatch->id,
                            'validity' => 'undecided',
                            'competition_id' => $landesliga->id
                        ]);
                    }
                    if ($info['cnj'] > 0) {
                        Score::create([
                            'amount' => $info['cnj'],
                            'competitor_id' => $c->id,
                            'workout_id' => $cnj->id,
                            'validity' => 'undecided',
                            'competition_id' => $landesliga->id
                        ]);
                    }
                }
            }

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
                'title' => 'SV90 Gräfenroda e.V. vs. ESV München Freimann'
            ]);

            $bundesliga->workouts()->sync([$snatch->id, $cnj->id]);

            $first_comps = [
                ['gender' => 'female', 'weight' => 53.9, 'sn' => 45, 'cnj' => 0, 'competitive' => true, 'name' => 'Marie-Sophie Breitschuh'],
                ['gender' => 'female', 'weight' => 56.0, 'sn' => 52, 'cnj' => 65, 'competitive' => true, 'name' => 'Julia Perlt'],
                ['gender' => 'male', 'weight' => 62, 'sn' => 80, 'cnj' => 95, 'competitive' => true, 'name' => 'Fritz Heyer'],

                ['gender' => 'female', 'weight' => 71.7, 'sn' => 60, 'cnj' => 0, 'competitive' => true, 'name' => 'Christina Büller'],
                ['gender' => 'male', 'weight' => 91.9, 'sn' => 110, 'cnj' => 140, 'competitive' => true, 'name' => 'Andre Langkabel'],
                ['gender' => 'male', 'weight' => 94.3, 'sn' => 120, 'cnj' => 150, 'competitive' => true, 'name' => 'Philipp Griebel'],

                ['gender' => 'male', 'weight' => 87.1, 'sn' => 0, 'cnj' => 120, 'competitive' => true, 'name' => 'Philipp Stecklum'],
                ['gender' => 'male', 'weight' => 76.3, 'sn' => 0, 'cnj' => 105, 'competitive' => true, 'name' => 'Nico Holtmann']
            ];
            $second_comps = [
                ['gender' => 'female', 'weight' => 66.7, 'sn' => 45, 'cnj' => 60, 'competitive' => true, 'name' => 'Verena Zierer'],
                ['gender' => 'female', 'weight' => 61.4, 'sn' => 55, 'cnj' => 67, 'competitive' => true, 'name' => 'Sarah Klitzke'],
                ['gender' => 'male', 'weight' => 70.0, 'sn' => 78, 'cnj' => 98, 'competitive' => true, 'name' => 'Jingyi Wang'],

                ['gender' => 'female', 'weight' => 70.9, 'sn' => 70, 'cnj' => 85, 'competitive' => true, 'name' => 'Anna-Carina Häusler'],
                ['gender' => 'female', 'weight' => 71, 'sn' => 65, 'cnj' => 80, 'competitive' => true, 'name' => 'Lisa Rieß'],
                ['gender' => 'male', 'weight' => 83.8, 'sn' => 114, 'cnj' => 150, 'competitive' => true, 'name' => 'Ali Isilay'],

                ['gender' => 'male', 'weight' => 97.3, 'sn' => 120, 'cnj' => 150, 'competitive' => true, 'name' => 'Florian Schnurrer']
            ];
            $first_flight_ids = [1,2,3,8,9,10,11];
            $second_flight_ids = [4,5,6,7,12,13,14,15];
            $team = $sv90;
            foreach ($first_comps as $info) {
                $c = Competitor::create(['name' => $info['name'], 'gender' => $info['gender'], 'team_id' => $team->id]);
                $bundesliga->competitors()->attach($c, ['weight' => $info['weight'], 'competitive' => $info['competitive']]);
                for ($i = 0; $i < 3; $i++) {
                    if ($info['sn'] > 0) {
                        Score::create([
                            'amount' => $info['sn'],
                            'competitor_id' => $c->id,
                            'workout_id' => $snatch->id,
                            'validity' => 'undecided',
                            'competition_id' => $bundesliga->id
                        ]);
                    }
                    if ($info['cnj'] > 0) {
                        Score::create([
                            'amount' => $info['cnj'],
                            'competitor_id' => $c->id,
                            'workout_id' => $cnj->id,
                            'validity' => 'undecided',
                            'competition_id' => $bundesliga->id
                        ]);
                    }
                }
            }
            $team = $esvmuen;
            foreach ($second_comps as $info) {
                $c = Competitor::create(['name' => $info['name'], 'gender' => $info['gender'], 'team_id' => $team->id]);
                $bundesliga->competitors()->attach($c, ['weight' => $info['weight']]);
                for ($i = 0; $i < 3; $i++) {
                    if ($info['sn'] > 0) {
                        Score::create([
                            'amount' => $info['sn'],
                            'competitor_id' => $c->id,
                            'workout_id' => $snatch->id,
                            'validity' => 'undecided',
                            'competition_id' => $bundesliga->id
                        ]);
                    }
                    if ($info['cnj'] > 0) {
                        Score::create([
                            'amount' => $info['cnj'],
                            'competitor_id' => $c->id,
                            'workout_id' => $cnj->id,
                            'validity' => 'undecided',
                            'competition_id' => $bundesliga->id
                        ]);
                    }
                }
            }

            $sn1 = Flight::create(['title' => '1. Gruppe Reißen', 'competition_id' => $bundesliga->id]);
            $sn2 = Flight::create(['title' => '2. Gruppe Reißen', 'competition_id' => $bundesliga->id]);
            $cnj1 = Flight::create(['title' => '1. Gruppe Stoßen', 'competition_id' => $bundesliga->id]);
            $cnj2 = Flight::create(['title' => '2. Gruppe Stoßen', 'competition_id' => $bundesliga->id]);
            $all = Flight::create(['title' => 'Alle', 'competition_id' => $bundesliga->id]);

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


        }
        # create dummy athletes

    }
}
