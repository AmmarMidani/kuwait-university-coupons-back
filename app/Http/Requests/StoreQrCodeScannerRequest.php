<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQrCodeScannerRequest extends FormRequest
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
            // 'entries' => 'required|array|min:1',
            // 'entries.*.meal_id' => 'required|exists:meals,id',
            // 'entries.*.student_id' => 'required|exists:students,id',
            // 'entries.*.user_id' => 'required|exists:users,id',
            // 'entries.*.effective_date' => 'required|date|date_format:Y-m-d',
        ];
    }

    public function messages(): array
    {
        return [
            // 'entries.required' => 'No data found to store.',
            // 'entries.*.meal_id.required' => 'Meal is required for each entry.',
            // 'entries.*.student_id.required' => 'Student is required for each entry.',
            // 'entries.*.user_id.required' => 'Merchant is required for each entry.',
            // 'entries.*.effective_date.required' => 'Effective date is required for each entry.',
        ];
    }
}
