<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueExamSchedule;


class UpdateExam extends FormRequest
{
    public function rules()
    {
        return [
            'course_instructor_id' => 'required|integer|exists:course_instructors,id',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
            'duration' => 'required|integer',
            'campus_id' => 'required|integer|exists:campuses,id',
            'room_id' => ['required', 'integer', 'exists:rooms,id', new UniqueExamSchedule($this->route('exam'))],
        ];
    }
}
