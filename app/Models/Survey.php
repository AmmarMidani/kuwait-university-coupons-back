<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    /** @use HasFactory<\Database\Factories\SurveyFactory> */
    use HasFactory;

    // hasMany relations
    public function surveyQuestions()
    {
        return $this->hasMany(SurveyQuestion::class, 'survey_id');
    }

    public function surveyStudents()
    {
        return $this->hasMany(SurveyStudent::class, 'survey_id');
    }
}
