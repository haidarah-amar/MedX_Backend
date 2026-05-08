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
            'category_id' => 'required|exists:departments_categories,id',
            'description_en' => 'required|string|max:255',
            'description_ar' => 'required|string|max:255',
        ];
    }
}
