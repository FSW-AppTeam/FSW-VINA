<?php

namespace Database\Seeders;

use App\Models\Survey;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class surveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Survey::factory()
            ->count(2)
            ->hasSurveyStudents(5)
            ->create();
    }
}
