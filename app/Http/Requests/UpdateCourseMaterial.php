<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseMaterial extends FormRequest
{
    public function rules()
    {
        return [
            'course_id' => 'sometimes|exists:courses,id',
            'title' => 'sometimes|string|max:100',
            'description' => 'sometimes|string',
            'file_path' => 'sometimes|string|max:255',
            'uploaded_by' => 'sometimes|exists:users,id',
        ];
    }
}
