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

    public function surveys()
    {
        return $this->hasMany(Survey::class, 'student_id');
    }
}
