<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseMaterial extends FormRequest
{
    public function rules()
    {
        return [
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'file_path' => 'required|string|max:255',
            'uploaded_by' => 'required|exists:users,id',
        ];
    }
}
