<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use League\Csv\Writer;
use App\Models\SurveyStudent;

class SurveyExport
{
    /**
     * Checks the student finished at datetime, if
     * older than 1 hour after last submission then
     * runs the csv export
     *
     * @param int $surveyId
     * @throws Exception
     */
    public function checkExportCsv(int $surveyId): string
    {
        $survey = Survey::find($surveyId);
        $res = $this->exportCsv($surveyId);

        $date = now()->format('Y-m-d-H_i-');
        $csv = Writer::createFromString();
        try {
            $csv->insertOne($res['header']);
        } catch (CannotInsertRecord|Exception $e) {
            dump($e->getMessage());
        }
        try {
            $csv->insertAll($res['full_answer']);
        } catch (CannotInsertRecord|Exception $e) {
            dump($e->getMessage());
        }

        $fileName = $date.$survey->survey_code.'-export.csv';
        Storage::disk('local')->put('csv/' . $fileName, $csv->toString());
        SurveyStudent::setExportedFinished($surveyId);
        return $fileName;
    }

    protected function setHeaderCsv(array $surveys, array $header): array
    {
        // sets the header
        foreach ($surveys as $survey) {
            if (!in_array($survey['question_title'], $header, true)) {
                if($survey['question_type'] === "json") {
                    switch ($survey['question_id']) {
                        case 7:
                        case 9:
                        case 14:
                        case 15:
                        case 18:
                        case 20:{
                            $header[] = $survey['question_title'] . " ID";
                            $header[] = $survey['question_title'] . " waarde";
                            break;
                        }

                        case 22:{
                            $header[] = $survey['question_title'] . " IDs";
                            $header[] = $survey['question_title'] . " waarde";
                            break;
                        }

                        default:
                        {
                            $header[] = $survey['question_title'];
                        }
                    }
                } else {
                    $header[] = $survey['question_title'];
                }
            }
        }

        return array_unique($header);
    }

    /**
     * Export formatter
     *
     */
    protected function exportCsv(string $surveysId): array
    {
        $surveys = SurveyStudent::getAnswersForExport($surveysId);
        $header = ['Respondent code', 'Klas code', 'Starttijd', 'Eindtijd'];
        $studentIds = [];
        $answers = [];

        $header = $this->setHeaderCsv($surveys, $header);
        // sets the first answers set
        foreach ($surveys as $survey) {
            if (!in_array($survey['student_id'], $studentIds)) {
                $studentIds[] = $survey['student_id'];
                $answers[$survey['student_id']]['Respondent code'] = $survey['student_id'];

                $startDateTime = SurveyAnswer::where('student_id', $survey['student_id'])->orderBy('created_at', 'asc')->first()->created_at;
                $answers[$survey['student_id']]['Starttijd'] = date_create($startDateTime)->format('H:i');

                $answers[$survey['student_id']]['Eindtijd'] = date_create($survey['finished_at'] )->format('H:i');
                if($survey['finished_at'] === null) {
                    $answers[$survey['student_id']]['Eindtijd'] = 'not finished';
                }
            }

            $answer = json_decode($survey['student_answer']);
            switch ($survey['question_type']) {
                case "int":
                case "text":
                case "string":
                {
                    $answers[$survey['student_id']][$survey['question_title']] = empty($answer) ? '' : $answer;
                    break;
                }

                case "array":
                {
                    $answers[$survey['student_id']][$survey['question_title']] = implode(', ', $answer);
                    break;
                }

                case "json":
                {
                    switch ($survey['question_id']) {
                        case 7:
                        {
                            $answers[$survey['student_id']][$survey['question_title'] . " ID"] = $answer->country_id;
                            $answers[$survey['student_id']][$survey['question_title'] . " waarde"] = $answer->other_country;
                            break;
                        }
                        case 9:
                        {
                            $answers[$survey['student_id']][$survey['question_title'] . " ID"] = $answer->religion;
                            $answers[$survey['student_id']][$survey['question_title'] . " waarde"] = $answer->other_religion;
                            break;
                        }
                        case 13:
                        {
                            $new = [];
                            foreach ($answer as $val) {
                                if (isset($val->country)) {
                                    if($val->id === 6){
                                        $new[] = $val->country;
                                    } else {
                                        $new[] = $val->id;
                                    }
                                }
                            }

                            $answers[$survey['student_id']][$survey['question_title']] = implode(', ', $new);
                            break;
                        }

                        case 14:
                        {
                            $new = [];
                            foreach ($answer->countries as $country) {
                                $new[] = $country->country;
                            }

                            if (in_array($survey['question_title'] . " ID", $header)) {
                                $answers[$survey['student_id']][$survey['question_title'] . " ID"] = $answer->student_id;
                                $answers[$survey['student_id']][$survey['question_title'] . " waarde"] = implode(', ', $new);
                            }

                            break;
                        }

                        case 12:
                        {
                            if (in_array($survey['question_title'] . " ID", $header)) {
                                $answers[$survey['student_id']][$survey['question_title'] . " ID"] = $answer->student_id;
                                $answers[$survey['student_id']][$survey['question_title'] . " waarde"] = implode(', ', $answer->value);
                            }
                            break;
                        }

                        case 15:
                            if (in_array($survey['question_title'] . " ID", $header)) {
                                $answers[$survey['student_id']][$survey['question_title'] . " ID"] = $answer->student_id;
                                if(isset($answer->answer->value)) {
                                    $answers[$survey['student_id']][$survey['question_title'] . " waarde"] = $answer->answer->value;
                                } else {
                                    $answers[$survey['student_id']][$survey['question_title'] . " waarde"] = '';
                                }
                            }

                            break;
                        case 22:
                        {
                            if (in_array($survey['question_title'] . " IDs", $header)) {
                                $answers[$survey['student_id']][$survey['question_title'] . " IDs"] = $answer[0]->id . ", " . $answer[0]->relation_id;
                                $answers[$survey['student_id']][$survey['question_title'] . " waarde"] = is_array($answer[0]->value) ? '' : $answer[0]->value;
                            }

                            break;
                        }

                        default:
                        {
                            if (in_array($survey['question_title'] . " ID", $header)) {
                                $answers[$survey['student_id']][$survey['question_title'] . " ID"] = $answer->id;
                                $answers[$survey['student_id']][$survey['question_title'] . " waarde"] = $answer->value;
                            }
                        }
                    }

                    break;
                }
            }
        }

        // sets the full answers set
        $fullAnswerRow = [];
        foreach ($studentIds as $studentId) {
            foreach ($header as $head) {
                if (array_key_exists($head, $answers[$studentId])) {
                    $fullAnswerRow[$studentId][] = $answers[$studentId][$head];
                } else {
                    $fullAnswerRow[$studentId][] = '';
                }
            }
        }

        return ['header' => $header, 'full_answer' => $fullAnswerRow];
    }

}
