<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssignment extends FormRequest
{
    public function rules()
    {
        return [
            'course_id' => 'sometimes|integer|exists:courses,id',
            'title' => 'sometimes|string|max:100',
            'description' => 'sometimes|string',
            'due_date' => 'sometimes|date',
        ];
    }
}
