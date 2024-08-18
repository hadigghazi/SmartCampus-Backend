<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExam extends FormRequest
{
    public function rules()
    {
        return [
            'course_id' => 'sometimes|integer|exists:courses,id',
            'instructor_id' => 'sometimes|integer|exists:instructors,id',
            'date' => 'sometimes|date',
            'time' => 'sometimes|date_format:H:i:s',
            'duration' => 'sometimes|integer',
            'campus_id' => 'sometimes|integer|exists:campuses,id',
            'room_id' => 'sometimes|integer|exists:rooms,id',
        ];
    }
}
