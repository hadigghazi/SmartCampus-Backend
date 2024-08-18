<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDormRegistration extends FormRequest
{
    public function rules()
    {
        return [
            'student_id' => 'sometimes|exists:students,id',
            'dorm_room_id' => 'sometimes|exists:dorm_rooms,id',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date',
            'status' => 'sometimes|in:Pending,Confirmed,Canceled',
        ];
    }
}
