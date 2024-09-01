<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseDropRequest extends FormRequest
{
    public function rules()
    {
        return [
            'course_instructor_id' => 'required|exists:course_instructors,id',
            'reason' => 'required|string',
        ];
    }
}
