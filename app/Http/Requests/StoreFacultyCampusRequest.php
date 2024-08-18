<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFacultyCampusRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'faculty_id' => 'required|exists:faculties,id',
            'campus_id' => 'required|exists:campuses,id',
        ];
    }
}
