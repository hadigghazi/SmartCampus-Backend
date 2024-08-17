<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust as needed
    }

    public function rules()
    {
        return [
            'number' => 'required|max:20',
            'block_id' => 'required|exists:blocks,id',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable',
        ];
    }
}
