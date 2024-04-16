<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyAnswers extends Model
{
    use HasFactory;

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
//    protected $dateFormat = 'd-m-Y H:i:s';

    protected $casts = [
        'student_answer' => 'array'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'survey_id',
        'question_id',
        'question_type',
        'question_title',
        'student_answer',
    ];

    /**
     * Data mapper
     * @return Attribute
     */


    public function survey()
    {
        return $this->belongsTo(Survey::class, 'groups_id');
    }

    protected function data(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }

}
