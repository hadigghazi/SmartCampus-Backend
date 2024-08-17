<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => 'sometimes|exists:users,id',
            'first_name' => 'sometimes|string|max:50',
            'last_name' => 'sometimes|string|max:50',
            'relationship' => 'sometimes|string|max:50',
            'phone_number' => 'sometimes|string|max:20',
            'email' => 'sometimes|string|email|max:100',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
