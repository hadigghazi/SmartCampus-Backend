<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFacultyCampusRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'faculty_id' => 'sometimes|required|exists:faculties,id',
            'campus_id' => 'sometimes|required|exists:campuses,id',
        ];
    }
}
