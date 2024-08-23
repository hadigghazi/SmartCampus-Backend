<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLibraryBook extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:100',
            'author' => 'required|string|max:100',
            'isbn' => 'required|string|max:20',
            'copies' => 'required|integer',
            'publication_year' => 'required|integer',
            'campus_id' => 'required|exists:campuses,id',
            'description' => 'nullable|string',
            'pages' => 'required|integer|min:1',
        ];
        
    }
}
