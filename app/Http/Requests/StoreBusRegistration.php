<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBusRegistration extends FormRequest
{
    public function rules()
    {
        return [
            'student_id' => 'required|exists:students,id',
            'bus_route_id' => 'required|exists:bus_routes,id',
            'registration_date' => 'required|date',
            'status' => 'required|in:Pending,Confirmed,Canceled',
        ];
    }
}
