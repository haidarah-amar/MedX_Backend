<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
             'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $this->user()->id,
            'phone_number' => 'nullable|string|max:15',
            'gender' => 'nullable|in:female,male',
            'birthdate' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'id_passport' => 'nullable|string|max:255',
            'password' => 'sometimes|string|min:8|confirmed',
        ];
    }
}
