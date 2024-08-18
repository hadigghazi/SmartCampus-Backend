<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseInstructorRequest extends FormRequest
{
 
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'course_id' => 'sometimes|required|exists:courses,id',
            'instructor_id' => 'sometimes|required|exists:instructors,id',
            'semester_id' => 'sometimes|required|exists:semesters,id',
            'capacity' => 'sometimes|required|integer',
            'campus_id' => 'sometimes|required|exists:campuses,id',
            'room_id' => 'sometimes|required|exists:rooms,id',
            'schedule' => 'sometimes|required|string|max:100',
        ];
    }
    

}
