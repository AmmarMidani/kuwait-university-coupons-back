<?php

namespace App\Http\Controllers\API\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
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
}
