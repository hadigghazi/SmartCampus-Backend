<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistration extends FormRequest
{
    public function rules()
    {
        return [
            'student_id' => 'required|integer',
            'course_instructor_id' => 'required|integer',
            'semester_id' => 'required|integer',
            'status' => 'sometimes|in:Registered,Completed,Failed',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->input('status', 'Registered'),
        ]);
    }
}
