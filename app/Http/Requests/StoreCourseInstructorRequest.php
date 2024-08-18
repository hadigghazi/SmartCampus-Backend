<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseInstructorRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules()
    {
        return [
            'course_id' => 'required|exists:courses,id',
            'instructor_id' => 'required|exists:instructors,id',
            'semester_id' => 'required|exists:semesters,id',
            'capacity' => 'required|integer',
            'campus_id' => 'required|exists:campuses,id',
            'room_id' => 'required|exists:rooms,id',
            'schedule' => 'required|string|max:100',
        ];
    }
    
}
