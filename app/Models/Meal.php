<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    /** @use HasFactory<\Database\Factories\MealFactory> */
    use HasFactory;

    // hasMany relations

    public function mealPrices()
    {
        return $this->hasMany(MealPrice::class, 'meal_id');
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class, 'meal_id');
    }
}
