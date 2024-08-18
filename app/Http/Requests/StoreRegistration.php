<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistration extends FormRequest
{
    public function rules()
    {
        return [
            'student_id' => 'required|integer',
            'course_id' => 'required|integer',
            'instructor_id' => 'required|integer',
            'semester_id' => 'required|integer',
            'status' => 'required|in:Registered,Completed,Failed',
        ];
    }
}
