<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyManualMealEntryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'meal_id' => 'required|exists:meals,id',
            'user_id' => 'required|exists:users,id',
            'effective_date' => 'required|date|date_format:Y-m-d',
            'student_ids' => 'required|array',
            'student_ids.*' => 'required|exists:students,student_number',
        ];
    }

    public function messages()
    {
        return [
            'meal_id.required' => 'Please select a meal.',
            'meal_id.exists' => 'The selected meal does not exist.',
            'user_id.required' => 'Please select a merchant.',
            'user_id.exists' => 'The selected merchant does not exist.',
            'effective_date.required' => 'Please select a date.',
            'effective_date.date' => 'The effective date must be a valid date.',
            'effective_date.date_format' => 'The date format must be YYYY-MM-DD.',
            'student_ids.required' => 'Please enter at least one student number.',
            'student_ids.array' => 'Student numbers must be provided as a list.',
            'student_ids.*.required' => 'One or more student numbers are missing.',
            'student_ids.*.exists' => 'One or more student numbers are invalid or do not exist.',
        ];
    }
}
