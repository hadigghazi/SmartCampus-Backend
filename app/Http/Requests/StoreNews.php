<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNews extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:100',
            'content' => 'required|string',
            'published_date' => 'required|date',
            'author_id' => 'required|exists:users,id',
            'category' => 'required|string|max:50',
        ];
    }
}
