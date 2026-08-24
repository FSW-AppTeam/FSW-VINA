<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SurveyFriend
 *
 * @property int $id
 * @property int $survey_id
 * @property int $owner_student_id
 * @property string $name
 * @property int $position
 * @property Survey $survey
 * @property SurveyStudent $owner
 */
class SurveyFriend extends Model
{
    use HasFactory;

    protected $table = 'survey_friends';

    protected $casts = [
        'survey_id' => 'int',
        'owner_student_id' => 'int',
        'position' => 'int',
        'country_id' => 'int',
        'other_country' => 'string'
    ];

    protected $fillable = [
        'survey_id',
        'owner_student_id',
        'name',
        'position',
        'country_id',
        'other_country'
    ];

    /**
     * The survey this friend belongs to.
     */
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    /**
     * The participant who entered this friend.
     */
    public function owner()
    {
        return $this->belongsTo(
            SurveyStudent::class,
            'owner_student_id'
        );
    }
}