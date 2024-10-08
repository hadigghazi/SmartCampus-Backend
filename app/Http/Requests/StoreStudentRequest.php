<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'major_id' => 'required|exists:majors,id',
            'government_id' => 'required|string|max:20|unique:students,government_id',
            'civil_status_number' => 'required|string|max:20',
            'passport_number' => 'nullable|string|max:20|unique:students,passport_number',
            'visa_status' => 'nullable|string|max:50',
            'native_language' => 'required|string|max:50',
            'secondary_language' => 'required|string|max:50',
            'additional_info' => 'nullable|string',
        ];        
    }

    public function authorize()
    {
        return true;
    }
}
