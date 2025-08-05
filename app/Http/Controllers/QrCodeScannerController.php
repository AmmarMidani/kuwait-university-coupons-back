<?php

namespace App\Http\Controllers;

use App\Enums\GenderType;
use Illuminate\Http\Request;
use App\Http\Requests\StoreQrCodeScannerRequest;
use App\Http\Requests\VerifyQrCodeScannerRequest;
use App\Models\Meal;
use App\Models\Student;
use App\Models\Survey;
use Carbon\Carbon;

class QrCodeScannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $init_card = view('partials.qr-student-card-init')->render();
        return view('qr_code_scanner.show', compact('init_card'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQrCodeScannerRequest $request)
    {
        $student = Student::where('qr_code', $request->qr_code)->first();

        // Step 1: Check qr code
        if (!$student) {
            $error_message = 'QR code not found.';
            $html = view('partials.qr-student-card-danger', compact('error_message'))->render();
            return response()->json(['html' => $html]);
        }

        // Step 2: Check student account is active
        if (!$student->is_active) {
            $error_message = 'Your account is deactivated. Please contact administration.';
            $html = view('partials.qr-student-card-danger', compact('error_message'))->render();
            return response()->json(['html' => $html]);
        }

        // Step 3: Find current active meal
        $now = Carbon::now()->format('H:i:s');
        $meal = Meal::where('time_from', '<=', $now)
            ->where('time_to', '>=', $now)
            ->first();

        if (!$meal) {
            $error_message = 'No active meal available at this time.';
            $html = view('partials.qr-student-card-danger', compact('error_message'))->render();
            return response()->json(['html' => $html]);
        }

        // Step 4: Check if student already received this meal today
        $alreadyTaken = Survey::where('student_id', $student->id)
            ->where('meal_id', $meal->id)
            ->whereDate('created_at', Carbon::today())
            ->exists();

        if ($alreadyTaken) {
            $error_message = 'Student has already received this meal today.';
            $html = view('partials.qr-student-card-danger', compact('error_message'))->render();
            return response()->json(['html' => $html]);
        }

        $survey = new Survey();
        $survey->meal_id = $meal->id;
        $survey->student_id = $student->id;
        $survey->user_id = auth()->user()->id;
        $survey->save();

        $message = 'Meal has been successfully recorded.';

        $html = view('partials.qr-student-card-init', compact('message'))->render();
        return response()->json([
            'html' => $html,
            'survey_id' => $survey->id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function verify(VerifyQrCodeScannerRequest $request)
    {
        $student = Student::where('qr_code', $request->qr_code)->first();

        // Step 1: Check qr code
        if (!$student) {
            $error_message = 'QR code not found.';
            $html = view('partials.qr-student-card-danger', compact('error_message'))->render();
            return response()->json([
                'status' => false,
                'html' => $html
            ]);
        }

        // Step 2: Check student account is active
        if (!$student->is_active) {
            $error_message = 'Your account is deactivated. Please contact administration.';
            $html = view('partials.qr-student-card-danger', compact('error_message'))->render();
            return response()->json([
                'status' => false,
                'html' => $html
            ]);
        }

        // Step 3: Find current active meal
        $now = Carbon::now()->format('H:i:s');
        $meal = Meal::where('time_from', '<=', $now)
            ->where('time_to', '>=', $now)
            ->first();

        if (!$meal) {
            $error_message = 'No active meal available at this time.';
            $html = view('partials.qr-student-card-danger', compact('error_message'))->render();
            return response()->json([
                'status' => false,
                'html' => $html
            ]);
        }

        // Step 4: Check if student already received this meal today
        $alreadyTaken = Survey::where('student_id', $student->id)
            ->where('meal_id', $meal->id)
            ->whereDate('created_at', Carbon::today())
            ->exists();

        if ($alreadyTaken) {
            $error_message = 'Student has already received this meal today.';
            $html = view('partials.qr-student-card-danger', compact('error_message'))->render();
            return response()->json([
                'status' => false,
                'html' => $html
            ]);
        }

        $student->gender_text = GenderType::fromValue($student->gender)->description;
        $html = view('partials.qr-student-card-success', compact('student'))->render();

        $store_resp = $this->store(new StoreQrCodeScannerRequest($request->all()));
        $survey_id = $store_resp->getData()->survey_id;
        return response()->json([
            'status' => true,
            'print_receipt_url' => route('qr-code-scanner.print.receipt', $survey_id),
            'html' => $html,
        ]);
    }

    public function print_receipt(Survey $survey)
    {
        return view('qr_code_scanner.print_receipt', compact('survey'));
    }
}
