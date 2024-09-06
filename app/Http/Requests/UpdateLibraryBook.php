<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLibraryBook extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'sometimes|string|max:100',
            'author' => 'sometimes|string|max:100',
            'isbn' => 'sometimes|string|max:20',
            'copies' => 'sometimes|integer',
            'publication_year' => 'sometimes|integer',
            'campus_id' => 'sometimes|exists:campuses,id',
            'description' => 'nullable|string',
            'pages' => 'sometimes|integer|min:1',
        ];
    }
}
