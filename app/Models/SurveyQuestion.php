<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    /** @use HasFactory<\Database\Factories\SurveyQuestionFactory> */
    use HasFactory;

    // belongsTo relations
    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    // hasMany relations
    public function surveyStudentAnswers()
    {
        return $this->hasMany(SurveyStudentAnswer::class, 'survey_question_id');
    }
}
