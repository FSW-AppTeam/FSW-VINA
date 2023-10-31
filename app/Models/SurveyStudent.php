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
     *  Get export for csv
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

}
