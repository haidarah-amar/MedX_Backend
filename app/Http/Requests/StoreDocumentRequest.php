<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'category' => 'required|in:finance,reports,govermental',
            'description' => 'required|string',
            'file' => 'required|file|mimes:jpeg,png,jpg,webp,pdf,doc,docx,xlsx|max:10240', // 10MB max
        ];

        return $rules;
    }
}

