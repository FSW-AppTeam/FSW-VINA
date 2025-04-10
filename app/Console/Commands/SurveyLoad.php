<?php

namespace App\Console\Commands;

use App\Models\SurveyQuestion;
use Database\Seeders\QuestionSeeder;
use Illuminate\Console\Command;

class SurveyLoad extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'survey:load {questionsSet=default}';

    /**
     * @var string
     */
    protected $description = 'Load questions from the ?questions.json file!';

    /**
     * Execute the console command.
     */
    /**
     * Execute the console command.
     */
    public function handle(QuestionSeeder $seeder)
    {
        $this->info('Reload survey questions');

        $questionsSet = $this->argument('questionsSet');
        $seeder->run($questionsSet);
    }
}
