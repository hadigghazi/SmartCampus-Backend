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

}
