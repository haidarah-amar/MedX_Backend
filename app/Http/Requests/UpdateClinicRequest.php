<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClinicRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'sometimes|email|unique:clinics,email,' . auth('api')->id(),

            'password' => 'sometimes|min:6',

            'name_en' => 'sometimes|string|max:255',
            'name_ar' => 'sometimes|string|max:255',

            'owner_name' => 'sometimes|string|max:255',
            'owner_idphoto' => 'sometimes|string',

            'description_en' => 'sometimes|string',
            'description_ar' => 'sometimes|string',

            'location_en' => 'sometimes|string',
            'location_ar' => 'sometimes|string',

            'phone_number' => ['required','string','regex:/^09[0-9]{8}$/'],

            'working_hours' => 'sometimes|integer|min:1',

            'is_active' => 'sometimes|boolean',
            'is_24h' => 'sometimes|boolean',

            'latitude' => 'sometimes|string',
            'longitude' => 'sometimes|string',

            'logo' => 'sometimes|string',
        ];
    }
}
