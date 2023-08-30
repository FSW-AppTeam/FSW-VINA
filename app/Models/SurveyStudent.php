<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class SurveyStudent extends Model
{
    use HasFactory;
//    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'class_id',
        'survey_id',
    ];

    public function hashModel(){
//        $h = new Hashids\Hashids('this is my salt');
    }

//    /**
//     *  Setup model event hooks
//     */
//    public static function boot(): void
//    {
//        parent::boot();
//
////        self::creating(function ($model) {
////            $model->uuid = Str::uuid()->toString();
////        });
//    }

}
