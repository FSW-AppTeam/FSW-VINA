<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyStudent extends Model
{
    use HasFactory;

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
//    protected $dateFormat = 'd-m-Y H:i:s';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'class_id',
        'survey_id',
        'finished_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'finished_at'
    ];

    public function hashModel(){
//        $h = new Hashids\Hashids('this is my salt');
    }

    /**
     *  Setup model event hooks
     */
    public static function boot(): void
    {
        parent::boot();

//        self::creating(function ($model) {
//            $model->uuid = Str::uuid()->toString();
//        });
    }

    /**
     *  Get export answers for csv
     */
    public static function getAnswersForExport(int $surveyId, string $classId): array
    {
        return SurveyStudent::where('survey_students.survey_id', '=', $surveyId)
            ->where('class_id', '=', $classId)
            ->join('survey_answers', 'survey_students.id', '=', 'survey_answers.student_id')
            ->orderBy('survey_answers.question_id')
            ->get([
                'name',
                'survey_students.id as student_id',
                'student_answer',
                'question_title',
                'question_id',
                'question_type',
                'survey_students.created_at',
                'class_id',
                'finished_at',
                'exported_at'
            ])->toArray();
    }

    /**
     * Checks the student finished at datetime, if
     * older than 1 hour after last submission then
     * runs the csv export
     *
     * @return array
     */
    public static function getClassIdsForExport(): array
    {
        $exportClassIds = [];

        $students = SurveyStudent::
            where('finished_at', 'IS NOT', NULL)
            ->where('exported_at', '=', NULL)
            ->orderBy('finished_at', 'DESC')
            ->get()
            ->groupBy('class_id')
            ->toArray();

        foreach ($students as $classId => $student){
            $finishedSurvey = now()->parse($student[0]['finished_at']);
            $finishedSurvey->addHour();

            if ($finishedSurvey->lt(now())) {  // less than now
                $exportClassIds[] = $classId;
            }
        }

        return $exportClassIds;
    }

    public static function setExportedFinished(int $surveyId, array $classIds): void
    {
        SurveyStudent::where('survey_id', $surveyId)
            ->whereIn('class_id', $classIds)
            ->update([
                'exported_at' => now(),
                'name' => NULL,
            ]);
    }

}
