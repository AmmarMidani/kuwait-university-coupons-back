<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    /** @use HasFactory<\Database\Factories\NationalityFactory> */
    use HasFactory;

    // hasMany relations
    public function students()
    {
        return $this->hasMany(Student::class, 'nationality_id');
    }
}
