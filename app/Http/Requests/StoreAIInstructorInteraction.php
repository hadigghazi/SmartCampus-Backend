<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAIInstructorInteraction extends FormRequest
{
    public function rules()
    {
        return [
            'question' => 'required|string',
            'answer' => 'required|string',
        ];
    }
}
