<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssignment extends FormRequest
{
    public function rules()
    {
        return [
            'course_instructor_id' => 'sometimes|integer|exists:course_instructors,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'sometimes|date',
        ];
    }
}
