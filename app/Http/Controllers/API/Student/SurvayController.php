<?php

namespace App\Http\Controllers\API\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionCollection;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Models\SurveyAnswer;
use Illuminate\Support\Facades\DB;

class SurvayController extends Controller
{
    use ApiResponser;

    public function getQuestions(Request $request)
    {
        $questions = Question::all();
        return $this->successResponse(200, 'api.public.done', 200, new QuestionCollection($questions));
    }

    public function submitSurvayAnswers(Request $request, Survey $survay)
    {
        $auth_student = $request->user();
        if ($auth_student->id != $survay->student->id) {
            abort(403, 'Unauthorized action.');
        }

        if ($survay->is_answerd) {
            return $this->successResponse(200, 'api.public.already_voted', 200, []);
        }

        $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.answer' => 'required',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->answers as $answer) {
                SurveyAnswer::create([
                    'survey_id' => $survay->id,
                    'question_id' => $answer['question_id'],
                    'answer' => $answer['answer'],
                ]);
            }
            DB::commit();
            return $this->successResponse(200, 'api.public.done', 200, []);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(500, 'api.public.failed', 500);
        }
        return [$auth_student, $survay->is_answerd, $survay->student];
    }
}
