<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstructorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'department_id' => 'required|exists:departments,id',
            'specialization' => 'required|string|max:100',
            'salary' => 'required|numeric'
        ];
    }
}
