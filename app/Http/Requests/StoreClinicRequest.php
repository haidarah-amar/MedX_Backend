<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:clinics,email',
            'password' => 'required|min:6',

            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',

            'owner_name' => 'required|string|max:255|regex:/^[\p{Arabic}\s]+$/u',
            
            'owner_idphoto' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',


            'description_en' => 'required|string',
            'description_ar' => 'required|string',

            'location_en' => 'required|string',
            'location_ar' => 'required|string',

            'phone_number' => ['required','string','regex:/^09[0-9]{8}$/'],

            'working_hours' => 'required|integer|min:1',

            'is_active' => 'required|boolean',
            // 'is_24h' => 'required|boolean',

            'latitude' => 'required|string',
            'longitude' => 'required|string',

            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            'percentage' => 'required|numeric|min:0|max:100',
        ];
    }
}
