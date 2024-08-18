<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDormRoomRequest extends FormRequest
{
    public function rules()
    {
        return [
            'dorm_id' => 'sometimes|exists:dorms,id',
            'room_number' => 'sometimes|string|max:20',
            'capacity' => 'sometimes|integer',
            'available_beds' => 'sometimes|integer',
            'floor' => 'sometimes|integer',
            'description' => 'nullable|string',
        ];
    }
}
