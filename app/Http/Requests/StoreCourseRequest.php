<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code' => 'required|max:10|unique:courses,code',
            'name' => 'required|max:100|unique:courses,name',
            'description' => 'nullable',
            'credits' => 'required|integer',
            'major_id' => 'required|exists:majors,id',
            'faculty_id' => 'required|exists:faculties,id',
        ];        
    }
}
