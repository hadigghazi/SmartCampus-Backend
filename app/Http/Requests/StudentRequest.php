<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'government_id' => 'required|string|max:20',
            'civil_status_number' => 'required|string|max:20',
            'passport_number' => 'required|string|max:20',
            'visa_status' => 'required|string|max:50',
            'native_language' => 'required|string|max:50',
            'secondary_language' => 'nullable|string|max:50',
            'current_semester_id' => 'required|exists:semesters,id',
            'additional_info' => 'nullable|string',
            'transportation' => 'required|boolean',
            'dorm_residency' => 'required|boolean',
            'emergency_contact_id' => 'nullable|exists:contacts,id',
        ];
    }
}
