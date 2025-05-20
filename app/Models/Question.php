<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory;

    // hasMany relations

    public function surveyAnswers()
    {
        return $this->hasMany(SurveyAnswer::class, 'question_id');
    }
}
