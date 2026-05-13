<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('clinic-api')->check();
    }

    public function rules(): array
    {
        return [
            'name_en' => 'sometimes|required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'name_ar' => 'sometimes|required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'specialization_en' => 'sometimes|required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'specialization_ar' => 'sometimes|required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'birthdate' => 'sometimes|required|date',
            'id_passport' => 'sometimes|required|string|max:255',
            'photo' => 'sometimes|required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'hourly_rate' => 'sometimes|required|integer|min:0',
            'working_hours' => 'sometimes|required|integer|min:1',
            ];
    }
}
