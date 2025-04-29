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
            UserSeeder::class,
            MealSeeder::class,
            NationalitySeeder::class,
            StudentSeeder::class,
            StudentMealSeeder::class,
            SurveySeeder::class,
            SurveyQuestionSeeder::class,
            SurveyStudentSeeder::class,
            SurveyStudentAnswerSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
