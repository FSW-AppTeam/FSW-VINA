<?php

namespace App\Jobs;

use App\Cron\SurveyExport;
use Artisan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SurveyExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
    )
    {

    }

    /**
     * Execute the job.
     */
    public function handle(SurveyExport $surveyExport): void
    {
        Artisan::call('app:export-csv-run');

    }
}
