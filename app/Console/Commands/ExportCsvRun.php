<?php

namespace App\Console\Commands;

use App\Models\SurveyExport;
use Illuminate\Console\Command;

class ExportCsvRun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-csv-run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the check on surveys and exports the csv files';

    /**
     * Execute the console command.
     */
    public function handle(SurveyExport $surveyExport): void
    {
        try {
            $surveyExport->checkExportCsv();
        } catch (\Exception $e) {
            dump($e->getMessage());
        }
    }
}
