<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealPrice extends Model
{
    /** @use HasFactory<\Database\Factories\MealPriceFactory> */
    use HasFactory;

    // belongsTo relations

    public function meal()
    {
        return $this->belongsTo(Meal::class, 'meal_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
