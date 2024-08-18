<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'country' => 'required|string|max:50',
            'area' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'street' => 'required|string|max:100',
            'building_floor' => 'required|string|max:100',
            'special_instruction' => 'nullable|string',
        ];
    }
}
