<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookBorrow extends FormRequest
{
    public function rules()
    {
        return [
            'student_id' => 'sometimes|exists:students,id',
            'book_id' => 'sometimes|exists:library_books,id',
            'due_date' => 'sometimes|date',
            'return_date' => 'nullable|date',
            'status' => 'sometimes|in:Requested,Rejected,Borrowed,Returned,Overdue',
            'notes' => 'nullable|string',
        ];
    }
}
