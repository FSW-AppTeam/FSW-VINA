<?php

namespace App\Http\Controllers;

use App\Cron\SurveyExport;

class SurveyController extends Controller
{
    protected int $surveyId = 1;

    protected SurveyExport $surveyExport;

    public function __construct(SurveyExport $surveyExport)
    {
        $this->surveyExport = $surveyExport;
    }

    public function checkSurveys()
    {
        try {
            $this->surveyExport->checkExportCsv($this->surveyId);
        } catch (\Exception $exception){
            dump("Ooops... Something went wrong with the CSV export job!!");
        }

    }


    public function index()
    {
        dd("csv export view");

        return view('export');
    }
}
