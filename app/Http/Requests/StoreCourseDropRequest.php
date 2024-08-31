<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseDropRequest extends FormRequest
{
    public function rules()
    {
        return [
            'student_id' => 'required|exists:students,id',
            'course_instructor_id' => 'required|exists:course_instructors,id',
            'reason' => 'required|string',
            'status' => 'required|in:Pending,Approved,Rejected',
        ];
    }
}
