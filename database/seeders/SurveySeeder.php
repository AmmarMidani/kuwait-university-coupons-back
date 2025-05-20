<?php

namespace Database\Seeders;

use App\Models\Meal;
use App\Models\Question;
use App\Models\Student;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::role('merchant')->pluck('id')->toArray();
        $students = Student::all();
        $meals = Meal::where('is_active', true)->get();
        $questions = Question::all()->pluck('id')->toArray();

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
                    $survey = Survey::create([
                        'student_id' => $student->id,
                        'meal_id' => $meal->id,
                        'user_id' => fake()->randomElement($users),
                        'created_at' => $created_at,
                        'updated_at' => $created_at
                    ]);

                    if (fake()->boolean()) {
                        foreach ($questions as $key => $value) {
                            SurveyAnswer::create([
                                'survey_id' => $survey->id,
                                'question_id' => $value,
                                'answer' => fake()->numberBetween(1, 5)
                            ]);
                        }
                    }
                }
            }
        }
    }
}
