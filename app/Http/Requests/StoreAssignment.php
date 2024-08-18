<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssignment extends FormRequest
{
    public function rules()
    {
        return [
            'course_id' => 'required|integer|exists:courses,id',
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'due_date' => 'required|date',
        ];
    }
}
