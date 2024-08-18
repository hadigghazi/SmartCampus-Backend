<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAIInstructorInteraction extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => 'sometimes|exists:users,id',
            'question' => 'sometimes|string',
            'answer' => 'sometimes|string',
        ];
    }
}
