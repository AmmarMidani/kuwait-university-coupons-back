<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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

    public function activeMerchants()
    {
        return $this->hasManyThrough(User::class, MealPrice::class, 'meal_id', 'id', 'id', 'user_id')
            ->whereDate('meal_prices.effective_date', '<=', now());
    }

    public function getMerchantsAttribute(): Collection
    {
        return $this->activeMerchants->unique('id')->values();
    }
}
