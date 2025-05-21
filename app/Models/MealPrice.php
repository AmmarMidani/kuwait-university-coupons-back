<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealPrice extends Model
{
    /** @use HasFactory<\Database\Factories\MealPriceFactory> */
    use HasFactory;

    protected $fillable = ['created_at', 'effective_date', 'id', 'meal_id', 'price', 'updated_at', 'user_id'];

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
