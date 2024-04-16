<?php

namespace App\Http\Controllers;

use App\Models\SurveyExport;
use Illuminate\Support\Facades\Storage;

class SurveyController extends Controller
{
    public function __construct()
    {
    }

    public function checkSurvey($surveyId)
    {
        $surveyExport = new SurveyExport();
        try {
            $surveyExport->checkExportCsv($surveyId);
        } catch (\Exception $exception){

            dump("Ooops... Something went wrong with the CSV export job!!");
        }

    }

    public function index()
    {
        $directory = "csv";
        $files = Storage::files($directory);

        foreach ($files as $key => $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) !== 'csv') {
                unset($files[$key]);
            }
        }

        return view('export', compact('files'));
    }
}
