<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    /** @use HasFactory<\Database\Factories\NationalityFactory> */
    use HasFactory;

    protected $fillable = ['created_at', 'id', 'is_active', 'name', 'updated_at'];

    // hasMany relations

    public function students()
    {
        return $this->hasMany(Student::class, 'nationality_id');
    }
}
