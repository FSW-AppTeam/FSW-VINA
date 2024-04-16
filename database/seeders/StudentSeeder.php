<?php

namespace Database\Seeders;

use App\Models\SurveyStudent;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
       SurveyStudent::factory()
            ->count(20)

            ->create();
    }
}
