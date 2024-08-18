<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBusRegistration extends FormRequest
{
    public function rules()
    {
        return [
            'student_id' => 'sometimes|exists:students,id',
            'bus_route_id' => 'sometimes|exists:bus_routes,id',
            'registration_date' => 'sometimes|date',
            'status' => 'sometimes|in:Pending,Confirmed,Canceled',
        ];
    }
}
