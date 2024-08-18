<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImportantDate extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'end_date' => 'nullable|date',
            'type' => 'required|in:Deadline,Event,Holiday,Other',
        ];
    }
}
