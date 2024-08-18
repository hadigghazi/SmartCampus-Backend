<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRegistration extends FormRequest
{
    public function rules()
    {
        return [
            'student_id' => 'sometimes|integer',
            'course_id' => 'sometimes|integer',
            'instructor_id' => 'sometimes|integer',
            'semester_id' => 'sometimes|integer',
            'status' => 'sometimes|in:Registered,Completed,Failed',
        ];
    }
}
