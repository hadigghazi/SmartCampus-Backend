<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCenterRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'name' => 'required|max:100',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'overview' => 'nullable|string',
        ];
    }
}
