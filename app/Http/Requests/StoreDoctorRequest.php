<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('clinic-api')->check();
    }

    public function rules(): array
    {
        return [
            'name_en' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'name_ar' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'specialization_en' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'specialization_ar' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'birthdate' => 'required|date',
            'id_passport' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'hourly_rate' => 'required|integer|min:0',
            'working_hours' => 'required|integer|min:1',
            ];
    }
}
