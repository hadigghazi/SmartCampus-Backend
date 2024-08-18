<?php

namespace App\Http\Controllers;

use App\Models\CoursePrerequisite;
use App\Http\Requests\StoreCoursePrerequisiteRequest;
use App\Http\Requests\UpdateCoursePrerequisiteRequest;

class CoursePrerequisiteController extends Controller
{
    public function index()
    {
        $coursePrerequisites = CoursePrerequisite::withTrashed()->get();
        return response()->json($coursePrerequisites);
    }

    public function store(StoreCoursePrerequisiteRequest $request)
    {
        $coursePrerequisite = CoursePrerequisite::create($request->validated());
        return response()->json($coursePrerequisite, 201);
    }

    public function show(CoursePrerequisite $coursePrerequisite)
    {
        return response()->json($coursePrerequisite);
    }

    public function update(UpdateCoursePrerequisiteRequest $request, CoursePrerequisite $coursePrerequisite)
    {
        $coursePrerequisite->update($request->validated());
        return response()->json($coursePrerequisite);
    }

}
