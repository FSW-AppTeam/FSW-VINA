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
        $this->call(QuestionSeeder::class);
        //For convenience:

        Role::create([
            'name' => 'user',
            'created_at' => '2022-01-28T09:10:40.000000Z',
            'updated_at' => '2022-01-28T09:10:42.000000Z',
        ]);
        Role::create([
            'name' => 'administrator',
            'created_at' => '2022-01-28T09:10:40.000000Z',
            'updated_at' => '2022-01-28T09:10:42.000000Z',
        ]);

        User::create([
            'name' => 'daan',
            'role_id' => 2,
            'email' => 'daan@test.nl',
            'solis_id' => '0219959',
        ]);
        User::create([
            'name' => 'daan2',
            'role_id' => 2,
            'email' => 'daan2@test.nl',
            'solis_id' => 'assche011',
        ]);
    }
}
