<?php

namespace App\Console\Commands;

use App\Models\SurveyStudent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Anonymize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:anonymize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replace all participant names with uuids';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::channel('cron_log')->info('Start anonymizing participant names');
        $this->info('Anonymize participant names');
        $students = SurveyStudent::whereRaw('name != uuid')->get();
        foreach ($students as $student) {
            $student->name = $student->uuid;
            Log::channel('cron_log')->info('Anonymize participant id', ['id' => $student->id]);
            $student->save();
        }
    }
}
