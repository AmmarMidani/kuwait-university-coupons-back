<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentMeal extends Model
{
    /** @use HasFactory<\Database\Factories\StudentMealFactory> */
    use HasFactory;

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
}
