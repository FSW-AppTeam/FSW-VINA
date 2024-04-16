<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SurveyStudent
 *
 * @property int $id
 * @property string|null $name
 * @property Carbon|null $finished_at
 * @property Carbon|null $exported_at
 * @property int $survey_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Survey $survey
 *
 * @package App\Models
 */
class SurveyStudent extends Model
{
    use HasFactory;
	protected $table = 'survey_students';

	protected $casts = [
		'finished_at' => 'datetime',
		'exported_at' => 'datetime',
		'survey_id' => 'int'
	];

	protected $fillable = [
		'name',
		'finished_at',
		'exported_at',
		'survey_id'
	];


    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    /**
     *  Get export answers for csv
     */
    public static function getAnswersForExport(int $surveyId): array
    {
        return SurveyStudent::where('survey_students.survey_id', '=', $surveyId)
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
                'finished_at',
                'exported_at'
            ])->toArray();
    }

    public static function setExportedFinished(int $surveyId): void
    {
        SurveyStudent::where('survey_id', $surveyId)
            ->update([
                'exported_at' => now()
            ]);
    }

}
