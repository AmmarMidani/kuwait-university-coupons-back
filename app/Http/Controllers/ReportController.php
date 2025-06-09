<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Survey;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function transaction()
    {
        return view('reports.transaction');
    }

    public function survey()
    {
        return view('reports.survey');
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
