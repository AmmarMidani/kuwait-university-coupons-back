<?php

namespace App\Http\Requests;

use App\Enums\GenderLookupType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'name' => 'required|min:3',
            'password' => 'required|confirmed|min:8',
            'gender_lookup' => ['required', Rule::in(GenderLookupType::getValues())],
            'roles' => 'required|array|min:1',
            'is_active' => 'required|boolean',
        ];
    }
}
