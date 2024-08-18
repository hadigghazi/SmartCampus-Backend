<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'country' => 'sometimes|required|string|max:50',
            'area' => 'sometimes|required|string|max:100',
            'city' => 'sometimes|required|string|max:100',
            'street' => 'sometimes|required|string|max:100',
            'building_floor' => 'sometimes|required|string|max:100',
            'special_instruction' => 'nullable|string',
        ];
    }
}
