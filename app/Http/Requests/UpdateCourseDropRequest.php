<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseDropRequest extends FormRequest
{
    public function rules()
    {
        return [
            'course_instructor_id' => 'sometimes|exists:course_instructors,id',
            'reason' => 'sometimes|string',
            'status' => 'sometimes|in:Pending,Approved,Rejected',
        ];
    }
}
