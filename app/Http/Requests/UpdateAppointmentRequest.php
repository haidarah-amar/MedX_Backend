<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_notes' => 'sometimes|string|max:255',
            'rating' => 'sometimes|nullable|numeric|min:1|max:5',
        ];
    }
}
