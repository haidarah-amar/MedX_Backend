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
            'category_id' => 'sometimes|required|exists:departments_categories,id',
            'description_en' => 'sometimes|required|string|max:255',
            'description_ar' => 'sometimes|required|string|max:255',
        ];
    }
}
