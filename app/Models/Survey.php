<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    /** @use HasFactory<\Database\Factories\SurveyFactory> */
    use HasFactory;

    protected $fillable = ['created_at', 'id', 'meal_id', 'student_id', 'updated_at', 'user_id'];

    public function getIsAnswerdAttribute(): bool
    {
        return ($this->surveyAnswers->count()) ? true : false;
    }

    // belongsTo relations

    public function meal()
    {
        return $this->belongsTo(Meal::class, 'meal_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // hasMany relations

    public function surveyAnswers()
    {
        return $this->hasMany(SurveyAnswer::class, 'survey_id');
    }
}
