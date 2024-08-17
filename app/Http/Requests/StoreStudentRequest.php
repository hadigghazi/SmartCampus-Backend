<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'government_id' => 'required|string|max:20',
            'civil_status_number' => 'required|string|max:20',
            'passport_number' => 'required|string|max:20',
            'visa_status' => 'required|string|max:50',
            'native_language' => 'required|string|max:50',
            'secondary_language' => 'required|string|max:50',
            'current_semester_id' => 'nullable|exists:semesters,id',
            'additional_info' => 'required|string',
            'transportation' => 'required|boolean',
            'dorm_residency' => 'required|boolean',
            'emergency_contact_id' => 'nullable|exists:contacts,id',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
