<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::withTrashed()->get();
        return response()->json($courses);
    }

    public function store(StoreCourseRequest $request)
    {
        $course = Course::create($request->validated());
        return response()->json($course, 201);
    }

    public function show(Course $course)
    {
        $course->load('major', 'faculty', 'exams', 'courseInstructors', 'prerequisites', 'prerequisiteCourses', 'registrations', 'assignments', 'courseMaterials', 'courseDropRequests');
        return response()->json($course);
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->validated());
        return response()->json($course);
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $course = Course::withTrashed()->findOrFail($id);
        $course->restore();
        return response()->json($course);
    }

    public function forceDelete($id)
    {
        $course = Course::withTrashed()->findOrFail($id);
        $course->forceDelete();
        return response()->json(null, 204);
    }
}
