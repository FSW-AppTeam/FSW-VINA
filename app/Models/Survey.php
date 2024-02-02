<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Survey
 *
 * @property int $id
 * @property string $survey_code
 * @property Carbon|null $started_at
 * @property Carbon|null $finished_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|SurveyAnswer[] $survey_answers
 * @property Collection|SurveyStudent[] $survey_students
 *
 * @package App\Models
 */
class Survey extends Model
{
    use HasFactory;

	protected $table = 'surveys';

	protected $casts = [
		'started_at' => 'datetime',
		'finished_at' => 'datetime'
	];

	protected $fillable = [
		'survey_code',
		'started_at',
		'finished_at'
	];

	public function surveyAnswers()
	{
		return $this->hasMany(SurveyAnswer::class, 'survey_id');
	}

	public function surveyStudents()
	{
		return $this->hasMany(SurveyStudent::class);
	}

    public static function checkCode($code)
    {
        return Survey::where('survey_code', $code)->exists();

    }
}
