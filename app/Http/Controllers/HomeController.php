<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Question;
use App\Models\Student;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['welcome', 'privacy']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $now = Carbon::now();

        // This week: today to 7 days ago
        $startOfWeek = $now->copy()->subDays(6)->startOfDay(); // 6 days ago at 00:00
        $endOfWeek = $now->copy()->endOfDay(); // today at 23:59

        // Last week: 7–13 days ago
        $startOfPreviousPeriod = $now->copy()->subDays(13)->startOfDay(); // 13 days ago
        $endOfPreviousPeriod = $now->copy()->subDays(7)->endOfDay(); // 7 days ago

        // meals counts
        $currentWeekMeals = Survey::whereBetween('updated_at', [$startOfWeek, $endOfWeek])->count();
        $previousWeekMeals = Survey::whereBetween('updated_at', [$startOfPreviousPeriod, $endOfPreviousPeriod])->count();
        $meals_change = $previousWeekMeals > 0
            ? round((($currentWeekMeals - $previousWeekMeals) / $previousWeekMeals) * 100, 2)
            : 0;

        // Survey counts
        $currentWeekSurveys = Survey::whereBetween('updated_at', [$startOfWeek, $endOfWeek])
            ->whereHas('surveyAnswers') // ensures it has at least one answer
            ->count();
        $previousWeekSurveys = Survey::whereBetween('updated_at', [$startOfPreviousPeriod, $endOfPreviousPeriod])
            ->whereHas('surveyAnswers')
            ->count();
        $survey_change = $previousWeekSurveys > 0
            ? round((($currentWeekSurveys - $previousWeekSurveys) / $previousWeekSurveys) * 100, 2)
            : 0;

        // Counts for top statistics
        $counts = [
            'students' => Student::count(),
            'merchants' => User::merchants()->count(),
            'meals' => $currentWeekMeals,
            'meals_diff' => $currentWeekMeals - $previousWeekMeals,
            'meals_change' => $meals_change,
            'meal_change_status' => $meals_change > 0 ? true : false,
            'surveys' => $currentWeekSurveys,
            'survey_diff' => $currentWeekSurveys - $previousWeekSurveys,
            'survey_change' => $survey_change,
            'survey_change_status' => $survey_change > 0 ? true : false,
        ];

        // Charts
        $weekDays = collect(range(0, 6))->map(function ($i) use ($now) {
            return $now->copy()->subDays(6 - $i)->format('D');
        })->toArray();

        // questions line chart
        $questions = Question::all();
        $questionsChartData = [];

        foreach ($questions as $question) {
            $dailyData = [];

            for ($i = 0; $i <= 6; $i++) {
                $day = $now->copy()->subDays(6 - $i)->format('Y-m-d');
                $average = SurveyAnswer::where('question_id', $question->id)
                    ->whereDate('updated_at', $day)
                    ->avg('answer');

                $dailyData[] = round($average ?? 0, 2);
            }

            $questionsChartData[] = [
                'name' => substr($question->question_text, 0, 25) . '...',
                'data' => $dailyData,
            ];
        }

        // meals bar chart
        $mealTypes = Meal::where('is_active', true)->get(['id', 'name']);
        $mealsChartData = [];

        foreach ($mealTypes as $meal) {
            $dailyCounts = [];

            for ($i = 0; $i <= 6; $i++) {
                $date = $now->copy()->subDays(6 - $i)->format('Y-m-d');
                $count = Survey::where('meal_id', $meal->id)->whereDate('updated_at', $date)->count();
                $dailyCounts[] = $count;
            }
            $mealsChartData[] = [
                'name' => $meal->name,
                'data' => $dailyCounts,
            ];
        }
        return view('home', compact('counts', 'questionsChartData', 'mealsChartData', 'weekDays'));
    }

    public function welcome()
    {
        $section_titles = [
            ['title' => '🛡️ Secure & Role-Based Access', 'content' => 'Built with robust authentication and role management, the system ensures that students, merchants, and administrators can only access what’s relevant to them — powered by Laravel Sanctum and Spatie Permissions.'],
            ['title' => '🍽️ Smart Meal Scheduling', 'content' => 'Meals are organized by specific time windows and dynamically presented based on the current time. Students can easily view what\'s upcoming or ongoing today.'],
            ['title' => '💳 Merchant-Specific Pricing', 'content' => 'Each meal can have multiple prices based on which merchant is providing it — complete with effective dates and dynamic retrieval through the API.'],
            ['title' => '📋 Feedback-Driven Surveys', 'content' => 'After each meal, students are invited to submit optional survey responses. This feedback loop helps improve food quality and service transparency.'],
            ['title' => '🔐 Student QR Authentication', 'content' => 'Each student has a unique, regenerable QR code tied to their account — used for quick identification, meal collection, and survey matching.'],
            ['title' => '📊 Real-Time Reporting & Analytics', 'content' => 'Admins can monitor meal activity, survey completion rates, and merchant participation in real-time, helping them make data-informed decisions efficiently.'],
        ];
        return view('welcome', compact('section_titles'));
    }

    public function privacy()
    {
        $effective_date = 'July 04, 2025';
        $last_updated = 'July 04, 2025';
        $email = 'admission@ku.edu.kw';
        $website = 'https://nxg-tech.com/';

        return view('privacy', compact('effective_date', 'last_updated', 'email', 'website'));
    }
}
