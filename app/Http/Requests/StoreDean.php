<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDean extends FormRequest
{
    public function rules()
    {
        return [
            'faculty_id' => 'required|exists:faculties,id',
            'campus_id' => 'required|exists:campuses,id',
            'role_description' => 'required|string',
        ];
    }
}
