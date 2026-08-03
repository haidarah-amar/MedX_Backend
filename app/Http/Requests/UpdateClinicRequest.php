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

            'phone_number' => ['sometimes','string','regex:/^09[0-9]{8}$/'],

            'start_time' => 'sometimes|date_format:H:i',
            'end_time' => 'sometimes|date_format:H:i|after:start_time',

            'is_active' => 'sometimes|boolean',
            
            'latitude' => 'sometimes|string',
            'longitude' => 'sometimes|string',

            'logo' => 'sometimes|string',
            'percentage' => 'sometimes|numeric|min:0|max:100',
        ];
    }
}
