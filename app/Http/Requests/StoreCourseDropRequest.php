<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseDropRequest extends FormRequest
{
    public function rules()
    {
        return [
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'reason' => 'required|string',
            'status' => 'required|in:Pending,Approved,Rejected',
        ];
    }
}
