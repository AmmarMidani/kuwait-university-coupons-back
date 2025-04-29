<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Meal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StudentMealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::pluck('id')->toArray();
        $students = Student::all();
        $meals = Meal::where('is_active', true)->get();

        // Get dates for last 5 days
        $dates = collect(range(0, 4))->map(function ($day) {
            return Carbon::now()->subDays($day)->format('Y-m-d');
        });

        foreach ($students as $student) {
            foreach ($dates as $date) {
                $dayMeals = $meals->random(rand(0, count($meals)))->unique();
                foreach ($dayMeals as $meal) {
                    $from = $date . ' ' . $meal->time_from;
                    $to = $date . ' ' . $meal->time_to;
                    $created_at = fake()->dateTimeBetween($from, $to);
                    DB::table('student_meals')->insert([
                        'user_id' => fake()->randomElement($users),
                        'student_id' => $student->id,
                        'meal_id' => $meal->id,
                        'created_at' => $created_at,
                        'updated_at' => $created_at
                    ]);
                }
            }
        }
    }
}
