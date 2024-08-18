<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBusRouteRequest extends FormRequest
{
    public function rules()
    {
        return [
            'route_name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'schedule' => 'nullable|string',
            'capacity' => 'required|integer',
            'campus_id' => 'required|exists:campuses,id',
        ];
    }
}
