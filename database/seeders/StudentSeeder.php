<?php

namespace Database\Seeders;

use App\Models\SurveyStudent;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
       SurveyStudent::factory()
            ->count(20)
            ->create();
    }
}
