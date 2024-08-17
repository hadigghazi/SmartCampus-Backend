<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'relationship' => 'required|string|max:50',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|string|email|max:100',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
