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
            'number' => 'sometimes|max:20',
            'block_id' => 'sometimes|exists:blocks,id',
            'capacity' => 'sometimes|integer|min:1',
            'description' => 'nullable',
        ];
    }
}
