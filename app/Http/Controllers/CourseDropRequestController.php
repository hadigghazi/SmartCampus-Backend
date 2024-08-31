<?php

namespace App\Http\Controllers;

use App\Models\CourseDropRequest;
use App\Http\Requests\StoreCourseDropRequest;
use App\Http\Requests\UpdateCourseDropRequest;

class CourseDropRequestController extends Controller
{
    public function index()
    {
        $items = CourseDropRequest::get();
        return response()->json($items);
    }

    public function store(StoreCourseDropRequest $request)
    {
        $item = CourseDropRequest::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = CourseDropRequest::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateCourseDropRequest $request, $id)
    {
        $item = CourseDropRequest::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = CourseDropRequest::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = CourseDropRequest::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = CourseDropRequest::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }

    public function requestDrop(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'course_instructor_id' => 'required|integer|exists:course_instructors,id',
            'reason' => 'required|string',
        ]);

        $dropRequest = CourseDropRequest::create([
            'student_id' => $validated['student_id'],
            'course_instructor_id' => $validated['course_instructor_id'],
            'reason' => $validated['reason'],
            'status' => 'Pending', 
        ]);

        return response()->json($dropRequest, 201);
    }

    public function getDropRequestsByInstructor($courseInstructorId)
    {
        $dropRequests = CourseDropRequest::where('course_instructor_id', $courseInstructorId)->get();
        return response()->json($dropRequests);
    }


    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Approved,Rejected',
        ]);

        $dropRequest = CourseDropRequest::findOrFail($id);
        $dropRequest->update(['status' => $validated['status']]);

        return response()->json($dropRequest);
    }

}
