<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('clinic-api')->check();
    }

    public function rules(): array
    {
        return [
            'name_en' => 'sometimes|required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'name_ar' => 'sometimes|required|string|max:255|regex:/^[\p{Arabic}\s]+$/u',
            'category_id' => 'sometimes|required|exists:departments_categories,id',
            'description_en' => 'sometimes|required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'description_ar' => 'sometimes|required|string|max:255|regex:/^[\p{Arabic}\s]+$/u',
            'location_ar' => 'sometimes|required|string|max:255',
            'location_en' => 'sometimes|required|string|max:255',
        ];
    }
}
