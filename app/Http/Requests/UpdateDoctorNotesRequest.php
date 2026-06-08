<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorNotesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('doctor-api')->check();
    }

    public function rules(): array
    {
        return [
            'doctor_notes' => 'required|string|max:5000',
        ];
    }
}