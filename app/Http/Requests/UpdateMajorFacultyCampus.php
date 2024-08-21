<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMajorFacultyCampus extends FormRequest
{
    public function rules()
    {
        return [
            'major_id' => 'sometimes|exists:majors,id',
            'faculty_campus_id' => 'sometimes|exists:faculties_campuses,id',
        ];
    }
}
