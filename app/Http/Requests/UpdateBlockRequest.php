<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlockRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'name' => 'required|max:100',
            'campus_id' => 'required|exists:campuses,id',
            'description' => 'nullable',
        ];
    }
}
