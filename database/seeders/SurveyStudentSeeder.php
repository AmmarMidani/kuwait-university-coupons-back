<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Survey;
use App\Models\SurveyStudent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SurveyStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $survey_ids = Survey::pluck('id')->toArray();
        $student_ids = Student::pluck('id')->toArray();

        foreach ($survey_ids as $survey_id) {
            $randomCount = rand(1, count($student_ids));
            $selected_students = fake()->randomElements($student_ids, $randomCount);

            // Add selected students to survey
            foreach ($selected_students as $student_id) {
                SurveyStudent::create([
                    'survey_id' => $survey_id,
                    'student_id' => $student_id,
                ]);
            }
        }
    }
}
