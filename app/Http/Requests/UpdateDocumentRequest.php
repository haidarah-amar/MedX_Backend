<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
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
        $rules = [
            'title' => 'nullable|string|max:255',
            'category' => 'nullable|in:finance,reports,govermental',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf,doc,docx,xlsx|max:10240', // 10MB max
        ];

        return $rules;
    }
}
