<?php

namespace App\Http\Controllers\API\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\Student as ResourcesStudent;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    use ApiResponser;

    public function login(Request $request)
    {
        $request->validate([
            'student_number' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $student = Student::where('student_number', $request->student_number)->first();

        if (! $student || ! Hash::check($request->password, $student->password)) {
            return $this->errorResponse(401, trans('api.auth.invalid_credentials'), 401);
        }

        $token = $student->createToken('student-token')->plainTextToken;

        return $this->successResponse(200, trans('api.auth.login'), 200, [
            'token' => $token,
            'student' => $student,
        ]);
    }

    public function profile(Request $request)
    {
        return $this->successResponse(200, trans('api.public.done'), 200, new ResourcesStudent($request->user()));
        return response()->json();
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse(200, trans('api.auth.loggedout'), 200, []);
    }

    // forgetPassword
    // resetPassword
}
