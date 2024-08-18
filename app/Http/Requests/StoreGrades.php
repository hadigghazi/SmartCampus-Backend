<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGrades extends FormRequest
{
    public function rules()
    {
        return [
            '80' => 'required|string',
        ];
    }
}
