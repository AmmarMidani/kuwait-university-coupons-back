<?php

namespace Database\Seeders;

use App\Models\Meal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Meal::factory()->create([
            'name' => 'Breakfast',
            'description' => 'Morning meal to start your day. Includes eggs, toast, coffee, juice, cereal, and fruit.',
            'time_from' => '09:00',
            'time_to' => '11:00',
            'is_active' => true,
        ]);
        Meal::factory()->create([
            'name' => 'Lunch',
            'description' => 'Midday meal to refuel. Includes sandwiches, salads, soups, and light entrees.',
            'time_from' => '15:00',
            'time_to' => '16:30',
            'is_active' => true,
        ]);
        Meal::factory()->create([
            'name' => 'Dinner',
            'description' => 'Evening meal to end the day. Includes main course, sides, appetizers and desserts.',
            'time_from' => '21:00',
            'time_to' => '22:30',
            'is_active' => true,
        ]);
        Meal::factory()->create([
            'name' => 'Suhoor',
            'description' => 'Pre-dawn meal during Ramadan. Includes dates, fruits, yogurt, bread and protein-rich foods.',
            'time_from' => '04:00',
            'time_to' => '04:30',
            'is_active' => false,
        ]);
        Meal::factory()->create([
            'name' => 'Iftar',
            'description' => 'Evening meal to break fast during Ramadan. Includes dates, water, soup, main dishes and traditional desserts.',
            'time_from' => '07:00',
            'time_to' => '08:30',
            'is_active' => false,
        ]);
        Meal::factory()->create([
            'name' => 'Extra Meal',
            'description' => null,
            'time_from' => '11:00',
            'time_to' => '11:30',
            'is_active' => false,
        ]);
    }
}
