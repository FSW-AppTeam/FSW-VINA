<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SurveyAnswer
 * 
 * @property int $id
 * @property string $student_id
 * @property int $question_id
 * @property string $question_type
 * @property string $question_title
 * @property string|null $student_answer
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class SurveyAnswer extends Model
{
	protected $table = 'survey_answers';

	protected $casts = [
		'question_id' => 'int'
	];

	protected $fillable = [
		'student_id',
		'question_id',
		'question_type',
		'question_title',
		'student_answer'
	];
}
