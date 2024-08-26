<?php

namespace App\Http\Controllers;

use App\Models\CoursePrerequisite;
use App\Http\Requests\StoreCoursePrerequisiteRequest;
use App\Http\Requests\UpdateCoursePrerequisiteRequest;

class CoursePrerequisiteController extends Controller
{
    public function index()
    {
        $coursePrerequisites = CoursePrerequisite::get();
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

    public function destroy(CoursePrerequisite $coursePrerequisite)
    {
        $coursePrerequisite->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $coursePrerequisite = CoursePrerequisite::withTrashed()->findOrFail($id);
        $coursePrerequisite->restore();
        return response()->json($coursePrerequisite);
    }

    public function forceDelete($id)
    {
        $coursePrerequisite = CoursePrerequisite::withTrashed()->findOrFail($id);
        $coursePrerequisite->forceDelete();
        return response()->json(null, 204);
    }

    public function getCoursePrerequisiteByCourse($courseId)
    {
        if (!is_numeric($courseId)) {
            return response()->json(['error' => 'Invalid course ID'], 400);
        }
    
        $prerequisites = CoursePrerequisite::where('course_id', $courseId)
            ->whereHas('prerequisiteCourse', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->with('prerequisiteCourse') 
            ->get();
    
        return response()->json($prerequisites);
    }
    
}
