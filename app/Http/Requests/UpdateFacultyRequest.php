<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFacultyRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'name' => 'required|max:100',
            'description' => 'nullable|string',
            'credit_price_usd' => 'sometimes|numeric|min:0'
        ];
    }
}
