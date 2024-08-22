<?php

namespace App\Http\Controllers;

use App\Models\CourseInstructor;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Campus;
use App\Models\Semester;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCourseInstructorRequest;
use App\Http\Requests\UpdateCourseInstructorRequest;

class CourseInstructorController extends Controller
{
    public function index()
    {
        $courseInstructors = CourseInstructor::get();
        return response()->json($courseInstructors);
    }

    public function store(StoreCourseInstructorRequest $request)
    {
        $courseInstructor = CourseInstructor::create($request->validated());
        return response()->json($courseInstructor, 201);
    }

    public function show(CourseInstructor $courseInstructor)
    {
        return response()->json($courseInstructor);
    }

    public function update(UpdateCourseInstructorRequest $request, CourseInstructor $courseInstructor)
    {
        $courseInstructor->update($request->validated());
        return response()->json($courseInstructor);
    }

    public function destroy(CourseInstructor $courseInstructor)
    {
        $courseInstructor->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $courseInstructor = CourseInstructor::withTrashed()->findOrFail($id);
        $courseInstructor->restore();
        return response()->json($courseInstructor);
    }

    public function forceDelete($id)
    {
        $courseInstructor = CourseInstructor::withTrashed()->findOrFail($id);
        $courseInstructor->forceDelete();
        return response()->json(null, 204);
    }

    public function getCourseOptions($id)
    {
        $courseOptions = CourseInstructor::where('course_id', $id)
            ->with('instructor', 'campus', 'semester', 'room') 
            ->get()
            ->map(function ($courseInstructor) {
                return [
                    'id' => $courseInstructor->id,
                    'instructor_name' => $courseInstructor->instructor->name,
                    'campus_name' => $courseInstructor->campus->name,
                    'schedule' => $this->formatSchedule($courseInstructor->schedule),
                    'available_seats' => $courseInstructor->capacity,
                    'semester_name' => $courseInstructor->semester->name,
                ];
            });

        return response()->json($courseOptions);
    }

    private function formatSchedule($schedule)
    {
      //TODO
        return $schedule;
    }
}
