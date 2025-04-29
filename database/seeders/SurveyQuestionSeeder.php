<?php

namespace Database\Seeders;

use App\Models\Survey;
use App\Models\SurveyQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SurveyQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $survey_ids = Survey::pluck('id')->toArray();
        foreach ($survey_ids as $survey_id) {
            $num_questions = rand(3, 5);
            for ($i = 0; $i < $num_questions; $i++) {
                SurveyQuestion::create([
                    'survey_id' => $survey_id,
                    'question_text' => fake()->realText(50),
                    'options' => json_encode([1, 2, 3, 4, 5]),
                ]);
            }
        }
    }
}
