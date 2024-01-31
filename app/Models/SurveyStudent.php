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
