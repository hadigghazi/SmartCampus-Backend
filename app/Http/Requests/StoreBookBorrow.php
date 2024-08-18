<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookBorrow extends FormRequest
{
    public function rules()
    {
        return [
            'student_id' => 'required|exists:students,id',
            'book_id' => 'required|exists:library_books,id',
            'due_date' => 'required|date',
            'return_date' => 'nullable|date',
            'status' => 'required|in:Borrowed,Returned,Overdue',
            'notes' => 'nullable|string',
        ];
    }
}
