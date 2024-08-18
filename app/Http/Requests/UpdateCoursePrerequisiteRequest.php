<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCoursePrerequisiteRequest extends FormRequest
{
    public function rules()
    {
        return [
            'course_id' => 'sometimes|required|exists:courses,id',
            'prerequisite_course_id' => 'sometimes|required|exists:courses,id|different:course_id',
        ];
    }
}
