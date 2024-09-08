<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDormRegistration extends FormRequest
{
    public function rules()
    {
        return [
            'student_id' => 'required|exists:students,id',
            'dorm_room_id' => 'required|exists:dorm_rooms,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ];
    }
}
