<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnnouncement extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:100',
            'content' => 'required|string',
            'published_date' => 'required|date',
            'author_id' => 'required|exists:users,id',
            'visibility' => 'required|string|in:General,Admins,Instructors,Students',
            'category' => 'required|string|in:General,Urgent,Event',
        ];        
    }
}
