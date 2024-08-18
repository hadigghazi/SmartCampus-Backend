<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAIInstructorInteraction extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'question' => 'required|string',
            'answer' => 'required|string',
        ];
    }
}
