<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBusRouteRequest extends FormRequest
{
    public function rules()
    {
        return [
            'route_name' => 'sometimes|required|string|max:100',
            'description' => 'nullable|string',
            'schedule' => 'nullable|string',
            'capacity' => 'sometimes|required|integer',
            'campus_id' => 'sometimes|required|exists:campuses,id',
        ];
    }
}
