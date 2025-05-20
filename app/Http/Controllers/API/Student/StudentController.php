<?php

namespace App\Http\Controllers\API\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\Meal as ResourcesMeal;
use App\Http\Resources\MerchantCollection;
use App\Http\Resources\SurveyCollection;
use App\Models\Meal;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    use ApiResponser;

    public function generateNewQr(Request $request)
    {
        $student = $request->user();
        $student->qr_code = (string) Str::uuid();
        $student->save();
        return $this->successResponse(200, trans('api.public.done'), 200, $student->qr_code);
    }

    public function nextUpcomingMeal(Request $request)
    {
        $now = Carbon::now()->format('H:i:s');

        $status = 'ongoing';
        // Check for ongoing meal
        $meal = Meal::where('is_active', true)
            ->where('time_from', '<=', $now)
            ->where('time_to', '>=', $now)
            ->orderBy('time_from', 'asc')
            ->first();

        // If none ongoing, get upcoming
        if (!$meal) {
            $status = 'upcoming';
            $meal = Meal::where('is_active', true)
                ->where('time_from', '>', $now)
                ->orderBy('time_from', 'asc')
                ->first();
        }

        if (!$meal) {
            return $this->successResponse(200, trans('api.public.no_meals_available'), 200, null);
        }

        return $this->successResponse(200, trans('api.public.done'), 200, [
            'status' => $status,
            'meal' => new ResourcesMeal($meal),
            'merchants' => new MerchantCollection($meal->merchants),
        ]);
    }

    public function pastMeals(Request $request)
    {
        $student = $request->user();

        $surveys = $student
            ->surveys()
            ->with('meal')
            ->with('user')
            ->orderByDesc('created_at')
            ->get();
        return $this->successResponse(200, trans('api.public.done'), 200, new SurveyCollection($surveys));
    }
}
