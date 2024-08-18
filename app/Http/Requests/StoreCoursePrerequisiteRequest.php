<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoursePrerequisiteRequest extends FormRequest
{
    public function rules()
    {
        return [
            'course_id' => 'required|exists:courses,id',
            'prerequisite_course_id' => 'required|exists:courses,id|different:course_id',
        ];
    }
}
