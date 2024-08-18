<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExam extends FormRequest
{
    public function rules()
    {
        return [
            'course_id' => 'required|integer|exists:courses,id',
            'instructor_id' => 'required|integer|exists:instructors,id',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
            'duration' => 'required|integer',
            'campus_id' => 'required|integer|exists:campuses,id',
            'room_id' => 'required|integer|exists:rooms,id',
        ];
    }
}
