<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteAllSurveyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-all-survey-data';

    /**
     * @var string
     */
    protected $description = 'Deletes all the survey data from the database!!! Be carefully! This job runs once per night at 03:00.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        DB::table('survey_students')->delete();
        DB::table('survey_answers')->delete();
    }
}
