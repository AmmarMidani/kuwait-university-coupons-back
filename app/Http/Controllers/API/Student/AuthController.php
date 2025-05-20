<?php

namespace App\Http\Controllers\API\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\Student as ResourcesStudent;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
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
    }

    public function changePassword(Request $request)
    {
        $request->validate(
            [
                'old_password' => 'required',
                'new_password' => 'required|min:8|different:old_password',
                'confirm_password' => 'required|same:new_password',
            ],
            [
                'confirm_password.required' => 'The confirm password is required.',
                'confirm_password.same' => 'The confirm password and new password must match.',
            ]
        );

        $user = auth()->user();
        if (!Hash::check($request->old_password, $user->password)) {
            return $this->errorResponse(422, trans('api.auth.old_password_incorrect'), 422, []);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);
        return $this->successResponse(200, trans('api.auth.password_updated'), 200, []);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse(200, trans('api.auth.loggedout'), 200, []);
    }
}
