<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    /** @use HasFactory<\Database\Factories\SurveyAnswerFactory> */
    use HasFactory;

    protected $fillable = ['answer', 'created_at', 'id', 'question_id', 'survey_id', 'updated_at'];

    // belongsTo relations

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }
}
