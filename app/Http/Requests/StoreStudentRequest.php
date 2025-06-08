<?php

namespace App\Http\Requests;

use App\Enums\GenderType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'program_id' => 'required|exists:programs,id',
            'nationality_id' => 'required|exists:nationalities,id',
            'gender' => ['required', Rule::in(GenderType::getValues())],
            'student_number' => 'required',
            'name' => 'required|min:3',
            'password' => 'required|confirmed|min:8',
            'date_from' => 'required|date|date_format:Y-m-d',
            'date_to' => 'required|date|date_format:Y-m-d|after_or_equal:date_from',
            'is_active' => 'required|boolean',
        ];
    }
}
