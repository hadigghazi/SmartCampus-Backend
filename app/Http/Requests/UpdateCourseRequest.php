<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code' => 'sometimes|max:10|unique:courses,code',
            'name' => 'sometimes|max:100|unique:courses,name',
            'description' => 'nullable',
            'credits' => 'sometimes|integer',
            'major_id' => 'sometimes|exists:majors,id',
            'faculty_id' => 'sometimes|exists:faculties,id',
        ];  
    }
}
