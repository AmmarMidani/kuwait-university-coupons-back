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
        'id',
        'nationality_id',
        'program_id',
        'student_number',
        'password',
        'qr_code',
        'name',
        'gender',
        'date_from',
        'date_to',
        'is_active',
        'created_at',
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

    // hasMany relations

    public function surveys()
    {
        return $this->hasMany(Survey::class, 'student_id');
    }
}
