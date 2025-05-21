<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    /** @use HasFactory<\Database\Factories\ProgramFactory> */
    use HasFactory;

    protected $fillable = ['created_at', 'id', 'name', 'updated_at'];

    // hasMany relations

    public function students()
    {
        return $this->hasMany(Student::class, 'program_id');
    }
}
