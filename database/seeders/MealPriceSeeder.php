<?php

namespace Database\Seeders;

use App\Models\Meal;
use App\Models\MealPrice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MealPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meals = Meal::all();
        $merchants = User::role('merchant')->get();

        foreach ($merchants as $merchant) {
            foreach ($meals as $meal) {
                for ($i = 0; $i < rand(1, 3); $i++) {
                    MealPrice::create([
                        'meal_id' => $meal->id,
                        'user_id' => $merchant->id,
                        'price' => rand(10, 50),
                        'effective_date' => Carbon::now()->subDays(rand(0, 7))->format('Y-m-d'),
                    ]);
                }
            }
        }
    }
}
