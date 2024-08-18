<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'capacity' => 'required|integer',
            'available_rooms' => 'required|integer',
            'campus_id' => 'required|exists:campuses,id',
            'address' => 'required|string',
        ];
    }
}
