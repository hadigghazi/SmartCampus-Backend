<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNews extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'sometimes|string|max:100',
            'content' => 'sometimes|string',
            'published_date' => 'sometimes|date',
            'author_id' => 'sometimes|exists:users,id',
            'category' => 'sometimes|string|max:50',
        ];
    }
}
