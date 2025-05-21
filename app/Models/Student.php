<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'created_at',
        'date_from',
        'date_to',
        'gender',
        'id',
        'is_active',
        'name',
        'nationality_id',
        'password',
        'program_id',
        'qr_code',
        'student_number',
        'updated_at'
    ];

    protected $hidden = [
        'password',
    ];

    // belongsTo relations

    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'nationality_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    // hasMany relations

    public function surveys()
    {
        return $this->hasMany(Survey::class, 'student_id');
    }
}
