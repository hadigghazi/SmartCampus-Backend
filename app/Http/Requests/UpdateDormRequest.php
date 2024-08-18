<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:100',
            'description' => 'sometimes|string',
            'capacity' => 'sometimes|integer',
            'available_rooms' => 'sometimes|integer',
            'campus_id' => 'sometimes|exists:campuses,id',
            'address' => 'sometimes|string',
        ];
    }
}
