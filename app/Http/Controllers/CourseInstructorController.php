<?php

namespace App\Http\Controllers;

use App\Models\CourseInstructor;
use App\Http\Requests\StoreCourseInstructorRequest;
use App\Http\Requests\UpdateCourseInstructorRequest;

class CourseInstructorController extends Controller
{
    public function index()
    {
        $courseInstructors = CourseInstructor::withTrashed()->get();
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

}
