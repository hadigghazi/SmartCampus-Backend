<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMajorFacultyCampus extends FormRequest
{
    public function rules()
    {
        return [
            'major_id' => 'required|exists:majors,id',
            'faculty_campus_id' => 'required|exists:faculties_campuses,id',
        ];
    }
}
