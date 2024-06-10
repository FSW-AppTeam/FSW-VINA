<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SurveyAnswer
 *
 * @property int $id
 * @property string $student_id
 * @property int $question_id
 * @property string $question_type
 * @property string $question_title
 * @property string|array|null $student_answer
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class SurveyAnswer extends Model
{
    use HasFactory;

    protected $table = 'survey_answers';

    protected $casts = [
        'question_id' => 'int',
        'student_answer' => 'array',
    ];

    protected $fillable = [
        'student_id',
        'question_id',
        'question_type',
        'question_title',
        'student_answer',
    ];

    public function student()
    {
        return $this->belongsTo(SurveyStudent::class);
    }

    protected function data(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }
}
