<?php

namespace App\Http\Controllers;

use App\Models\SurveyAnswers;
use App\Models\SurveyStudent;
use Illuminate\Http\Request;
use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use League\Csv\Writer;
use Illuminate\Support\Facades\Storage;

class SurveyController extends Controller
{
    protected $surveyId = 1;
    public function __construct()
    {

    }

    public function checkSurveys()
    {
        $this->exportCsv();
    }

    /**
     * Export formatter
     *
     * @throws CannotInsertRecord
     * @throws Exception
     */
    public function exportCsv()
    {
        $surveys = SurveyStudent::getAnswersForExport(1, "test");

        $header = ['Respond code', 'Klas code', 'Starttijd', 'Eindtijd'];
        $studentIds = [];
        $answers = [];
        $records = [];

        foreach ($surveys as $survey) {
            if ($survey['question_id'] < 22) {

                if (!in_array($survey['student_id'], $studentIds)) {
                    $studentIds[] = $survey['student_id'];
                    $answers[$survey['student_id']][] = $survey['student_id'];
                    $answers[$survey['student_id']][] = $survey['class_id'];
                    $answers[$survey['student_id']][] = date_create($survey['created_at'])->format('H:i');
                    $answers[$survey['student_id']][] = date_create($survey['finished_at'])->format('H:i');
                }

                if (!in_array($survey['question_title'], $header)) {
                    $header[] = $survey['question_title'];
                }

                $answer = json_decode($survey['student_answer']);

                switch($survey['question_type'])
                {
                    case "int":
                    case "text":{
                        $answers[$survey['student_id']][] = empty($answer) ? "" : $answer[0];
                        break;
                    }

                    case "array":{
                        $answers[$survey['student_id']][] = implode(', ', $answer);
                        break;
                    }

                    case "json":{
                        switch($survey['question_id']){
                            case 13:{
                                $new = [];
                                foreach ($answer as $val){
                                    if($val->id === 6){ // custom country
                                        $val->id = $val->country;
                                    }
                                    $new[] = $val->id;
                                }
                                $answers[$survey['student_id']][] = implode(', ', $new);
                                break;
                            }

                            case 14:{
                                $new = [];
                                foreach ($answer[0]->countries as $val){
                                    if($val->id === 6){ // custom country
                                        $val->id = $val->country;
                                    }
                                    $new[] = $val->id;
                                }
                                $answers[$survey['student_id']][] = implode(', ', $new);
                                break;
                            }

                            case 18:
                            case 20:{
                                if(str_ends_with($survey['question_title'], "ID")){
                                    $answers[$survey['student_id']][] = $answer[0]->id;
                                } else {
                                    $answers[$survey['student_id']][] = $answer[0]->value;
                                }

                                break;
                            }

                            case 22:{
                                dd($answer);

                                $answers[$survey['student_id']][] = $answer[0]->id;
                                break;
                            }

                            default: {
                                if(is_array($answer[0]->value)){
                                    $answers[$survey['student_id']][] = implode(', ', $answer[0]->value);
                                } else {
                                    $answers[$survey['student_id']][] = implode(', ', [$answer[0]->value]);
                                }
                            }

                        }

                        break;
                    }
                }

            }
        }

        $records [] = $answers;
        $csv = Writer::createFromString();

        $csv->insertOne($header);
        $csv->insertAll($records[0]);

//      $csv->output('export.csv'); // for http download

        Storage::disk('local')->put('public/csv/export.csv', $csv->toString());

        dump($csv->toString());
    }

    public function index()
    {
        dd("csv export ");

        return view('export');
    }
}
