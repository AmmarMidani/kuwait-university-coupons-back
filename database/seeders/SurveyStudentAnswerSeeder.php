<?php

namespace Database\Seeders;

use App\Models\SurveyStudent;
use App\Models\SurveyStudentAnswer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SurveyStudentAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $surveyStudents = SurveyStudent::with('survey.surveyQuestions')->get();

        foreach ($surveyStudents as $surveyStudent) {
            $questions = $surveyStudent->survey->surveyQuestions;

            foreach ($questions as $question) {
                $options = json_decode($question->options, true);
                $randomOption = fake()->randomElement($options);

                SurveyStudentAnswer::create([
                    'survey_student_id' => $surveyStudent->id,
                    'survey_question_id' => $question->id,
                    'selected_option' => $randomOption,
                ]);
            }
        }
    }
}
