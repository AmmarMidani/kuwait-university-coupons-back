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
            'time_from' => '09:00',
            'time_to' => '11:00',
            'is_active' => true,
        ]);
        Meal::factory()->create([
            'name' => 'Lunch',
            'time_from' => '15:00',
            'time_to' => '16:30',
            'is_active' => true,
        ]);
        Meal::factory()->create([
            'name' => 'Dinner',
            'time_from' => '21:00',
            'time_to' => '22:30',
            'is_active' => true,
        ]);
        Meal::factory()->create([
            'name' => 'Suhoor',
            'time_from' => '04:00',
            'time_to' => '04:30',
            'is_active' => false,
        ]);
        Meal::factory()->create([
            'name' => 'Iftar',
            'time_from' => '07:00',
            'time_to' => '08:30',
            'is_active' => false,
        ]);
    }
}
