<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SurveyQuestion
 *
 * @property int $id
 * @property int $order
 * @property bool $enabled
 * @property string $form_type
 * @property string $question_type
 * @property int $depends_on_question
 * @property string $question_title
 * @property string $question_content
 * @property array|null $question_answer_options
 * @property array|null $question_options
 * @property bool $default_disable_next
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class SurveyQuestion extends Model
{
    protected $table = 'survey_questions';

    protected $casts = [
        'order' => 'int',
        'enabled' => 'bool',
        'question_answer_options' => 'array',
        'question_options' => 'array',
        'default_disable_next' => 'bool',
        'depends_on_question' => 'int',
    ];

    protected $fillable = [
        'order',
        'enabled',
        'form_type',
        'question_type',
        'question_title',
        'question_content',
        'question_answer_options',
        'question_options',
        'default_disable_next',
        'depends_on_question',
    ];

    public function nextQuestion()
    {
        return SurveyQuestion::where('order', '>', $this->order)
            ->orderBy('order', 'asc')
            ->where('enabled', true)->first();
    }

    public function surveyAnswers()
    {
        return $this->hasMany(SurveyAnswer::class, 'question_id');
    }

}
