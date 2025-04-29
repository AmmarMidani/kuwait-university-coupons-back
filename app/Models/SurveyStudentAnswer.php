<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyStudentAnswer extends Model
{
    /** @use HasFactory<\Database\Factories\SurveyStudentAnswerFactory> */
    use HasFactory;

    // belongsTo relations
    public function surveyQuestion()
    {
        return $this->belongsTo(SurveyQuestion::class, 'survey_question_id');
    }

    public function surveyStudent()
    {
        return $this->belongsTo(SurveyStudent::class, 'survey_student_id');
    }
}
