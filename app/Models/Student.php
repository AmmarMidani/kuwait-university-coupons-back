<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

    // belongsTo relations
    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'nationality_id');
    }

    // hasMany relations
    public function studentMeals()
    {
        return $this->hasMany(StudentMeal::class, 'student_id');
    }

    public function surveyStudents()
    {
        return $this->hasMany(SurveyStudent::class, 'student_id');
    }
}
