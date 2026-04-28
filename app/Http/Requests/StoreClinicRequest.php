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
            'owner_idphoto' => 'required',
            'owner_idphoto.*' => 'file|image|mimes:jpeg,png,jpg,webp|max:2048',


            'description_en' => 'required|string',
            'description_ar' => 'required|string',

            'location_en' => 'required|string',
            'location_ar' => 'required|string',

            'phone_number' => ['required','string','regex:/^09[0-9]{8}$/'],

            'working_hours' => 'nullable|integer|min:1',

            'is_active' => 'nullable|boolean',
            'is_24h' => 'nullable|boolean',

            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',

            'logo' => 'nullable',
            'logo.*' => 'file|image|mimes:jpeg,png,jpg,webp|max:2048'
        ];
    }
}
