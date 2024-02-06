<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SurveySeeder::class);
        //For convenience:
        User::create([

            'name' => 'daan',
            'email' => 'daan@test.nl',
            'solis_id' => '0219959',
        ]);
        User::create([

            'name' => 'daan2',
            'email' => 'daan2@test.nl',
            'solis_id' => 'assche011',
        ]);
    }
}
