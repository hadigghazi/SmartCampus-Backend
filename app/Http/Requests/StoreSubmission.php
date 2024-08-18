<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubmission extends FormRequest
{
    public function rules()
    {
        return [
            'assignment_id' => 'required|integer|exists:assignments,id',
            'student_id' => 'required|integer|exists:students,id',
            'file_path' => 'required|string|max:255',
            'submission_date' => 'required|date',
            'grade' => 'required|numeric|min:0|max:100',
        ];
    }
}
