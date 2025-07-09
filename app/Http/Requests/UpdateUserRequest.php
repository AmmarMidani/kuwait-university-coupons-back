<?php

namespace App\Http\Requests;

use App\Enums\GenderLookupType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'name' => 'required|min:3',
            'password' => 'nullable|confirmed|min:8',
            'roles' => 'required|array|min:1',
            'gender_lookup' => ['required', Rule::in(GenderLookupType::getValues())],
            'is_active' => 'required|boolean',
        ];
    }
}
