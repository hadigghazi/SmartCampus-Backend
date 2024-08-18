<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDormRoomRequest extends FormRequest
{
    public function rules()
    {
        return [
            'dorm_id' => 'required|exists:dorms,id',
            'room_number' => 'required|string|max:20',
            'capacity' => 'required|integer',
            'available_beds' => 'required|integer',
            'floor' => 'required|integer',
            'description' => 'nullable|string',
        ];
    }
}
