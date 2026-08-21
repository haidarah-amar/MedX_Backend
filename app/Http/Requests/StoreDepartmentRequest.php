<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('clinic-api')->check();
    }

    public function rules(): array
    {
        return [
            'name_en' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'name_ar' => 'required|string|max:255|regex:/^[\p{Arabic}\s]+$/u',
            'category_id' => 'required|exists:departments_categories,id',
            'description_en' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'description_ar' => 'required|string|max:255|regex:/^[\p{Arabic}\s]+$/u',
            'location_ar' => 'required|string|max:255',
            'location_en' => 'required|string|max:255',
        ];
    }
}
