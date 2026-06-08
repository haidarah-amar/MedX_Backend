<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('clinic-api')->check();
    }

    public function rules(): array
    {
        return [
            'doctor_id' => 'required|exists:doctors,id',
            'department_id' => 'required|exists:departments,id',
            'hourly_rate' => 'required|numeric|min:0|max:999.99',
        ];
    }
}