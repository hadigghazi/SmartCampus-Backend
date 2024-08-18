<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDean extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|string',
            'faculty_id' => 'sometimes|exists:faculties,id',
            'campus_id' => 'sometimes|exists:campuses,id',
            'role_description' => 'sometimes|string',
        ];
    }
}
