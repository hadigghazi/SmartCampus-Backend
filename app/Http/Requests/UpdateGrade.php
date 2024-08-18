<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGrade extends FormRequest
{
    public function rules()
    {
        return [
            'registration_id' => 'sometimes|integer|exists:registrations,id',
            'grade' => 'sometimes|numeric|min:0|max:100',
            'letter_grade' => 'sometimes|in:A,B,C,D,F',
            'gpa' => 'sometimes|numeric|min:0|max:4',
        ];
    }
}
