<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'number' => 'required|max:20|unique:rooms,number',
            'block_id' => 'required|exists:blocks,id',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable',
        ];
    }
}
