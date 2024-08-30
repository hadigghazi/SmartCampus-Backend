<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssignment extends FormRequest
{
    public function rules()
    {
        return [
            'course_instructor_id' => 'required|integer|exists:course_instructors,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ];
    }
}
