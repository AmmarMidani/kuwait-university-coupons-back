<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyStudent extends Model
{
    /** @use HasFactory<\Database\Factories\SurveyStudentFactory> */
    use HasFactory;

    // belongsTo relations
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    // hasMany relations
    public function surveyStudentAnswers()
    {
        return $this->hasMany(SurveyStudentAnswer::class, 'survey_student_id');
    }
}
