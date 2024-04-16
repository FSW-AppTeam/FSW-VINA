<?php

namespace Database\Factories;

use App\Models\SurveyStudent;
use Illuminate\Database\Eloquent\Factories\Factory;

class SurveyStudentFactory extends Factory
{
    protected $model = SurveyStudent::class;

    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
        ];
    }
}
