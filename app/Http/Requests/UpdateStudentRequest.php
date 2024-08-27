<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'major_id' => 'sometimes|exists:majors,id',
            'government_id' => 'sometimes|string|max:20|unique:students,government_id',
            'civil_status_number' => 'sometimes|string|max:20',
            'passport_number' => 'nullable|string|max:20|unique:students,passport_number',
            'visa_status' => 'nullable|string|max:50',
            'native_language' => 'sometimes|string|max:50',
            'secondary_language' => 'sometimes|string|max:50',
            'current_semester_id' => 'nullable|exists:semesters,id',
            'additional_info' => 'nullable|string',
            'transportation' => 'sometimes|boolean',
            'dorm_residency' => 'sometimes|boolean',
        ];        
    }

    public function authorize()
    {
        return true;
    }
}
