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
            'name' => 'SV 90 Gräfenroda',
            'shorthand' => 'SV90'
        ]);
        $esvmuen = Team::create([
            'name' => 'ESV-Freimann München',
            'shorthand' => 'ESV-FM'
        ]);
        $esv_muehl = Team::create([
            'name' =>'ESV Mühlhausen',
            'shorthand' => 'ESV-M'
        ]);

        $isLandesliga = False;

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
                ['gender' => 'male', 'weight' => 84.0, 'sn' => 65, 'cnj' => 90, 'competitive' => true, 'name' => 'Stefan Heyder'],
                ['gender' => 'male', 'weight' => 92, 'sn' => 75, 'cnj' => 105, 'competitive' => true, 'name' => 'Sebastian Semper'],
                ['gender' => 'male', 'weight' => 82.2, 'sn' => 73, 'cnj' => 93, 'competitive' => true, 'name' => 'Mario Machleit'],
                ['gender' => 'male', 'weight' => 95.3, 'sn' => 97, 'cnj' => 118, 'competitive' => true, 'name' => 'Philipp Schreck'],
                ['gender' => 'male', 'weight' => 85.4, 'sn' => 80, 'cnj' => 110, 'competitive' => false, 'name' => 'Gregor Taube'],
                ['gender' => 'male', 'weight' => 107, 'sn' => 0, 'cnj' => 0, 'competitive' => false, 'name' => 'Tarek Schellhorn']
            ];
            $second_comps = [
                ['gender' => 'male', 'weight' => 96.2, 'sn' => 65, 'cnj' => 90, 'competitive' => true, 'name' => 'Matthias Hartwig'],
                ['gender' => 'male', 'weight' => 84.7, 'sn' => 66, 'cnj' => 85, 'competitive' => true, 'name' => 'Martin Weisheit'],
                ['gender' => 'male', 'weight' => 96.4, 'sn' => 70, 'cnj' => 95, 'competitive' => true, 'name' => 'Matthias Fiedler'],
                ['gender' => 'male', 'weight' => 83.9, 'sn' => 92, 'cnj' => 115, 'competitive' => true, 'name' => 'Christian Kühmstedt']
            ];
            $first_flight_ids = [1,2,7,8];
            $second_flight_ids = [3,4,5,9,10];
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
            $team = $esv_muehl;
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
                'title' => 'SV90 Gräfenroda e.V. vs. ESV Freimann München'
            ]);

            $bundesliga->workouts()->sync([$snatch->id, $cnj->id]);

            $first_comps = [
                ['gender' => 'male', 'weight' => 58.3, 'sn' => 68, 'cnj' => 82, 'competitive' => true, 'name' => 'Elias Sensche'],
                ['gender' => 'female', 'weight' => 58.1, 'sn' => 485, 'cnj' => 0, 'competitive' => true, 'name' => 'Marie-Sophie Breitschuh'],
                ['gender' => 'male', 'weight' => 64.4, 'sn' => 82, 'cnj' => 102, 'competitive' => true, 'name' => 'Fritz Heyer'],
                ['gender' => 'female', 'weight' => 56.0, 'sn' => 60, 'cnj' => 67, 'competitive' => true, 'name' => 'Julia Perlt'],
                ['gender' => 'male', 'weight' => 96.9, 'sn' => 126.0, 'cnj' => 157, 'competitive' => true, 'name' => 'Andre Langkabel'],
                ['gender' => 'male', 'weight' => 97.4, 'sn' => 125.0, 'cnj' => 155, 'competitive' => true, 'name' => 'Philipp Griebel'],
                ['gender' => 'male', 'weight' => 76.6, 'sn' => 0, 'cnj' => 114, 'competitive' => true, 'name' => 'Nico Holtmann']
            ];
            $second_comps = [
                ['gender' => 'female', 'weight' => 74, 'sn' => 69, 'cnj' => 87, 'competitive' => true, 'name' => 'Sarah Jacobs'],
                ['gender' => 'female', 'weight' => 70.7, 'sn' => 70, 'cnj' => 87, 'competitive' => true, 'name' => 'Anna-Carina Häusler'],
                ['gender' => 'female', 'weight' => 70.6, 'sn' => 74, 'cnj' => 94, 'competitive' => true, 'name' => 'Lisa Rieß'],
                ['gender' => 'female', 'weight' => 78.4, 'sn' => 71, 'cnj' => 0, 'competitive' => true, 'name' => 'Jessica Dannheimer'],
                ['gender' => 'male', 'weight' => 79.6, 'sn' => 102, 'cnj' => 136, 'competitive' => true, 'name' => 'Ali Isilay'],
                ['gender' => 'male', 'weight' => 102.3, 'sn' => 130, 'cnj' => 156, 'competitive' => true, 'name' => 'Florian Schnurrer'],
                ['gender' => 'male', 'weight' => 80.9, 'sn' => 0, 'cnj' => 130, 'competitive' => true, 'name' => 'Saadettin Karaca']
            ];
            $first_flight_ids = [1,2,3,7,8,9];
            $second_flight_ids = [4,5,6,10,11,12];
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
