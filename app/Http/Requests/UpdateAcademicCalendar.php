<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAcademicCalendar extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'sometimes|string|max:100',
            'description' => 'sometimes|string',
            'date' => 'sometimes|date',
            'end_date' => 'sometimes|date',
            'type' => 'sometimes|in:Deadline,Event,Holiday,Other',
        ];
    }
}
