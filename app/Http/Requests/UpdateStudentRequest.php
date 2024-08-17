<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => 'sometimes|exists:users,id',
            'government_id' => 'sometimes|string|max:20',
            'civil_status_number' => 'sometimes|string|max:20',
            'passport_number' => 'sometimes|string|max:20',
            'visa_status' => 'sometimes|string|max:50',
            'native_language' => 'sometimes|string|max:50',
            'secondary_language' => 'sometimes|string|max:50',
            'current_semester_id' => 'nullable|exists:semesters,id',
            'additional_info' => 'sometimes|string',
            'transportation' => 'sometimes|boolean',
            'dorm_residency' => 'sometimes|boolean',
            'emergency_contact_id' => 'nullable|exists:contacts,id',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
