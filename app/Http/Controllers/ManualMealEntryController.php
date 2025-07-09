<?php

namespace App\Http\Controllers;

use App\Enums\GenderLookupType;
use App\Enums\GenderType;
use App\Http\Requests\StoreManualMealEntryRequest;
use App\Http\Requests\VerifyManualMealEntryRequest;
use App\Models\Meal;
use App\Models\Student;
use App\Models\Survey;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManualMealEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::merchants()->get()->mapWithKeys(function ($item) {
            return [$item->id => $item->name];
        });
        $users->prepend('- Select Merchant -', null);

        $meals = Meal::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->name];
        });
        $meals->prepend('- Select Meal -', null);

        return view('manual_meal_entries.show', compact('meals', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreManualMealEntryRequest $request)
    {
        // Fetch all meals in one query and key them by ID
        $meals = Meal::pluck('time_from', 'id');

        foreach ($request->entries as $entry) {
            $exists = Survey::where('meal_id', $entry['meal_id'])
                ->where('student_id', $entry['student_id'])
                ->where('user_id', $entry['user_id'])
                ->whereDate('created_at', $entry['effective_date'])
                ->exists();

            if ($exists) continue;

            // Use the preloaded meal time_from
            $timeFrom = $meals[$entry['meal_id']] ?? null;
            if (!$timeFrom) continue;

            // Combine date and time into a Carbon instance
            $createdAt = Carbon::parse("{$entry['effective_date']} {$timeFrom}");

            Survey::create([
                'meal_id' => $entry['meal_id'],
                'student_id' => $entry['student_id'],
                'user_id' => $entry['user_id'],
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }

        return response()->json([
            'message' => 'Data are successfully saved'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function verify(VerifyManualMealEntryRequest $request)
    {
        $meal = Meal::find($request->meal_id);
        $user = User::find($request->user_id);
        $effective_date = $request->effective_date;
        $students = Student::whereIn('student_number', $request->student_ids)->get();

        return [
            'data' => $students->map(function ($student) use ($meal, $user, $effective_date) {
                return [
                    'student_number' => $student->student_number,
                    'student_name' => $student->name,
                    'meal_name' => $meal->name,
                    'merchant_name' => $user->name,
                    'effective_date' => $effective_date,
                    'student_id' => $student->id,
                    'meal_id' => $meal->id,
                    'user_id' => $user->id,
                    'hash' => md5($student->id . $meal->id . $user->id . $effective_date),
                ];
            }),
        ];
    }

    public function users(Request $request)
    {
        $user_id = $request->get('user_id');

        if (!$user_id) {
            return response()->json([
                'success' => true,
                'data' => collect() // empty collection
            ]);
        }

        $gender_lookup_user = User::find($user_id)->gender_lookup;

        switch ($gender_lookup_user) {
            case GenderLookupType::Male:
                $students = Student::where('gender', GenderType::Male)->get();
                break;
            case GenderLookupType::Female:
                $students = Student::where('gender', GenderType::Female)->get();
                break;
            case GenderLookupType::Both:
                $students = Student::all();
                break;
            default:
                $students = collect(); // empty collection
                break;
        }

        $mappedStudents = $students->mapWithKeys(function ($item) {
            return [$item->student_number => $item->name];
        });

        return response()->json([
            'success' => true,
            'data' => $mappedStudents
        ]);
    }
}
