<?php

use Illuminate\Database\Seeder;

use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(['name' => 'Stefan', 'email' => 'stefan.heyder@tu-ilmenau.de', 'password' => bcrypt('pimmelberger2018') ]);
        User::create(['name' => 'Seb', 'email' => 'sebastian.semper@tu-ilmenau.de', 'password' => bcrypt('pimmelberger2018') ]);
        User::create(['name' => 'Phili', 'email' => 'philipp.kunz-kaltenhaeuser@tu-ilmenau.de', 'password' => bcrypt('pimmelberger2018') ]);
    }
}
