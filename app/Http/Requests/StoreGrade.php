<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGrade extends FormRequest
{
    public function rules()
    {
        return [
            'registration_id' => 'required|integer|exists:registrations,id',
            'grade' => 'required|numeric|min:0|max:100',
            'letter_grade' => 'required|in:A,B,C,D,F',
            'gpa' => 'required|numeric|min:0|max:4',
        ];
    }
}
