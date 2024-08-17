<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCampusRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'name' => 'required|max:100',
            'location' => 'required|max:100',
            'description' => 'nullable|string',
        ];
    }
}
