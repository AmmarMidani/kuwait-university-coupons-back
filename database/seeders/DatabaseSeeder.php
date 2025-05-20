<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            UserSeeder::class,
            MealSeeder::class,
            NationalitySeeder::class,
            ProgramSeeder::class,
            MealPriceSeeder::class,
            QuestionSeeder::class,
            StudentSeeder::class,
            SurveySeeder::class,
        ]);
    }
}
