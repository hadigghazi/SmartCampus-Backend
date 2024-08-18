<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubmission extends FormRequest
{
    public function rules()
    {
        return [
            'assignment_id' => 'sometimes|integer|exists:assignments,id',
            'student_id' => 'sometimes|integer|exists:students,id',
            'file_path' => 'sometimes|string|max:255',
            'submission_date' => 'sometimes|date',
            'grade' => 'sometimes|numeric|min:0|max:100',
        ];
    }
}
