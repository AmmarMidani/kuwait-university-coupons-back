<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Question;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function transaction()
    {
        return view('reports.transaction');
    }

    public function survey(Request $request)
    {
        $date_from = data_get($request, 'date_from', now()->subMonths(5)->startOfMonth()->format('Y-m-d'));
        $date_to = data_get($request, 'date_to', now()->endOfMonth()->format('Y-m-d'));

        $question_id = data_get($request, 'question_id', null);
        $meal_id = data_get($request, 'meal_id', null);

        // Step 1: Generate month categories
        $months = collect();
        $start = Carbon::parse($date_from)->startOfMonth();
        $end = Carbon::parse($date_to)->endOfMonth();
        while ($start <= $end) {
            $months->push($start->format('Y-m'));
            $start->addMonth();
        }

        #region 1. Survey Participation Overview

        // Total surveys per month
        $totalSurveys = Survey::where('meal_id', $meal_id)
            ->whereBetween('updated_at', [$date_from, $date_to])
            ->selectRaw('DATE_FORMAT(updated_at, "%Y-%m") as ym, COUNT(*) as total')
            ->groupBy('ym')
            ->get()
            ->keyBy('ym');

        // Answered surveys per month (optionally filtered by question)
        $answeredQuery = SurveyAnswer::whereHas('survey', function ($q) use ($meal_id, $date_from, $date_to) {
            $q->where('meal_id', $meal_id)->whereBetween('updated_at', [$date_from, $date_to]);
        });
        if ($question_id) {
            $answeredQuery->where('question_id', $question_id);
        }

        $answeredSurveys = $answeredQuery
            ->join('surveys', 'survey_answers.survey_id', '=', 'surveys.id')
            ->selectRaw('DATE_FORMAT(surveys.updated_at, "%Y-%m") as ym, COUNT(DISTINCT surveys.id) as answered')
            ->groupBy('ym')
            ->get()
            ->keyBy('ym');

        $answeredData = [];
        $unansweredData = [];

        foreach ($months as $month) {
            $answered = (int) ($answeredSurveys[$month]->answered ?? 0);
            $total = (int) ($totalSurveys[$month]->total ?? 0);
            $unanswered = max($total - $answered, 0);

            $answeredData[] = $answered;
            $unansweredData[] = $unanswered;
        }

        $survey_participation_overview_chart = [
            'categories' => $months->toArray(),
            'series' => [
                ['name' => 'Answered Students', 'data' => $answeredData],
                ['name' => 'Unanswered Students', 'data' => $unansweredData],
            ]
        ];

        #endregion

        #region 2. Student Satisfaction by Question
        // Questions to include
        $questions = $question_id
            ? Question::where('id', $question_id)->pluck('question_text', 'id')
            : Question::all()->pluck('question_text', 'id');

        // Average answers per question per month
        $query = SurveyAnswer::query()
            ->whereHas('survey', function ($q) use ($meal_id, $date_from, $date_to) {
                $q->where('meal_id', $meal_id)->whereBetween('updated_at', [$date_from, $date_to]);
            });

        if ($question_id) {
            $query->where('question_id', $question_id);
        }

        $avgData = $query
            ->join('surveys', 'survey_answers.survey_id', '=', 'surveys.id')
            ->selectRaw('survey_answers.question_id, DATE_FORMAT(surveys.updated_at, "%Y-%m") as ym, AVG(answer) as avg')
            ->groupBy('survey_answers.question_id', 'ym')
            ->get()
            ->groupBy('question_id');

        // Format chart series
        $student_satisfaction_by_question_series = [];

        foreach ($questions as $qid => $qtext) {
            $data = $months->map(function ($month) use ($avgData, $qid) {
                return round((float) $avgData->get($qid)?->firstWhere('ym', $month)?->avg ?? 0, 2);
            })->toArray();

            $student_satisfaction_by_question_series[] = [
                'name' => $qtext,
                'data' => $data,
            ];
        }
        $student_satisfaction_by_question_categories = $months->toArray();

        #endregion

        // Overall Satisfaction
        $overallSatisfaction = SurveyAnswer::whereHas('survey', function ($q) use ($meal_id, $date_from, $date_to) {
            $q->where('meal_id', $meal_id)->whereBetween('updated_at', [$date_from, $date_to]);
        })
            ->when($question_id, fn($q) => $q->where('question_id', $question_id))
            ->avg('answer');
        $overallSatisfaction = $overallSatisfaction ? round($overallSatisfaction, 2) : '-';

        $totalResponses = SurveyAnswer::whereHas('survey', function ($q) use ($meal_id, $date_from, $date_to) {
            $q->where('meal_id', $meal_id)->whereBetween('updated_at', [$date_from, $date_to]);
        })
            ->when($question_id, fn($q) => $q->where('question_id', $question_id))
            ->count();

        // Total Responses
        $totalSurveys = Survey::where('meal_id', $meal_id)
            ->whereBetween('updated_at', [$date_from, $date_to])
            ->count();

        // Completion Rate
        $answeredSurveys = SurveyAnswer::whereHas('survey', function ($q) use ($meal_id, $date_from, $date_to) {
            $q->where('meal_id', $meal_id)->whereBetween('updated_at', [$date_from, $date_to]);
        })
            ->when($question_id, fn($q) => $q->where('question_id', $question_id))
            ->distinct('survey_id')
            ->count('survey_id');

        $completionRate = $totalSurveys > 0
            ? round(($answeredSurveys / $totalSurveys) * 100, 1) . '%'
            : '-';

        $counts = [
            'overallSatisfaction' => $overallSatisfaction,
            'totalResponses' => $totalResponses,
            'completionRate' => $completionRate,
        ];

        if ($request->ajax()) {
            return response()->json([
                'view' => view('partials.survey-report', compact(
                    'counts',
                    'survey_participation_overview_chart',
                    'student_satisfaction_by_question_series',
                    'student_satisfaction_by_question_categories',
                ))->render()
            ]);
        }

        $questions = Question::all()->pluck('question_text', 'id');
        $questions->prepend('- All Questions -', null);
        $meals = Meal::all()->pluck('name', 'id');

        return view('reports.survey', compact(
            'date_from',
            'date_to',
            'question_id',
            'meal_id',
            'questions',
            'meals',
        ));
    }

    public function meal(Request $request)
    {
        $date_from = data_get($request, 'date_from', now()->subMonths(5)->startOfMonth()->format('Y-m-d'));
        $date_to = data_get($request, 'date_to', now()->endOfMonth()->format('Y-m-d'));

        #region 1. Monthly Meal Distribution

        // Prepare months list as categories
        $start = Carbon::parse($date_from)->startOfMonth();
        $end = Carbon::parse($date_to)->endOfMonth();
        $monthly_meal_distribution_categories = collect();
        while ($start <= $end) {
            $monthly_meal_distribution_categories->push($start->format('Y-m'));
            $start->addMonth();
        }

        // Fetch all meal types
        $meals = Meal::all()->pluck('name', 'id');

        // Fetch survey counts grouped by meal_id and month
        $rawData = Survey::selectRaw('meal_id, DATE_FORMAT(updated_at, "%Y-%m") as month, COUNT(*) as total')
            ->whereBetween('updated_at', [$date_from, $date_to])
            ->groupBy('meal_id', 'month')
            ->get()
            ->groupBy('meal_id');

        // Build series for chart
        $monthly_meal_distribution_series = [];

        foreach ($meals as $meal_id => $meal_name) {
            $counts_by_month = collect($monthly_meal_distribution_categories)->map(function ($month) use ($rawData, $meal_id) {
                $record = $rawData->get($meal_id)?->firstWhere('month', $month);
                return $record ? (int) $record->total : 0;
            })->toArray();

            $monthly_meal_distribution_series[] = [
                'name' => $meal_name,
                'data' => $counts_by_month
            ];
        }
        #endregion

        #region 2. Weekday Distribution
        // Ordered weekday names starting from Saturday
        $weekday_distribution_categories = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        // Get meal types
        $meals = Meal::all()->pluck('name', 'id');

        // Fetch raw counts by meal_id and weekday
        $rawData = Survey::selectRaw("meal_id, DAYNAME(updated_at) as weekday, COUNT(*) as total")
            ->whereBetween('updated_at', [$date_from, $date_to])
            ->groupBy('meal_id', 'weekday')
            ->get()
            ->groupBy('meal_id');

        // Build series
        $weekday_distribution_series = [];

        foreach ($meals as $meal_id => $meal_name) {
            $data = collect($weekday_distribution_categories)->map(function ($day) use ($rawData, $meal_id) {
                $record = $rawData->get($meal_id)?->firstWhere('weekday', $day);
                return $record ? (int) $record->total : 0;
            })->toArray();

            $weekday_distribution_series[] = [
                'name' => $meal_name,
                'data' => $data
            ];
        }

        #endregion

        #region 3. Meal Type Distribution
        // Get meal types
        $meals = Meal::all()->pluck('name', 'id');

        // Count how many times each meal_id was taken
        $rawData = Survey::selectRaw("meal_id, COUNT(*) as total")
            ->whereBetween('updated_at', [$date_from, $date_to])
            ->groupBy('meal_id')
            ->get()
            ->keyBy('meal_id');

        // Build category and data arrays
        $meal_type_distribution_categories = [];
        $data = [];

        foreach ($meals as $meal_id => $meal_name) {
            $meal_type_distribution_categories[] = $meal_name;
            $data[] = isset($rawData[$meal_id]) ? (int) $rawData[$meal_id]->total : 0;
        }

        $meal_type_distribution_series = [
            [
                'name' => 'Meals',
                'data' => $data
            ]
        ];

        #endregion

        // Total Meals Served
        $totalMealsServed = Survey::whereBetween('updated_at', [$date_from, $date_to])->count();

        # Average Daily Meals
        $days = Carbon::parse($date_from)->diffInDays(Carbon::parse($date_to)) + 1;
        $averageDailyMeals = $days > 0 ? round($totalMealsServed / $days, 2) : 0;

        # Students Served
        $studentsServed = Survey::whereBetween('updated_at', [$date_from, $date_to])
            ->distinct('student_id')
            ->count('student_id');

        # Average Time of Meal Activity
        $averageHour = Survey::whereBetween('updated_at', [$date_from, $date_to])
            ->selectRaw('AVG(HOUR(updated_at)) as avg_hour')
            ->value('avg_hour');
        $averageMealTime = $averageHour !== null ? sprintf('%02d:00', round($averageHour)) : '-';

        $counts = [
            'totalMealsServed' => $totalMealsServed,
            'averageDailyMeals' => $averageDailyMeals,
            'studentsServed' => $studentsServed,
            'averageMealTime' => $averageMealTime,
        ];

        if ($request->ajax()) {
            return response()->json([
                'view' => view('partials.meal-report', compact(
                    'counts',
                    'monthly_meal_distribution_series',
                    'monthly_meal_distribution_categories',
                    'weekday_distribution_categories',
                    'weekday_distribution_series',
                    'meal_type_distribution_categories',
                    'meal_type_distribution_series',
                ))->render()
            ]);
        }

        return view('reports.meal', compact(
            'date_from',
            'date_to',
        ));
    }
}
