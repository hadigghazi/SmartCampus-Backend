<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Http\Requests\StoreInstructorRequest;
use App\Http\Requests\UpdateInstructorRequest;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function index()
    {
        $instructors = Instructor::get();
        return response()->json($instructors);
    }

    public function store(StoreInstructorRequest $request)
    {
        $instructor = Instructor::create($request->validated());
        return response()->json($instructor, 201);
    }

    public function show(Instructor $instructor)
    {
        return response()->json($instructor);
    }

    public function update(UpdateInstructorRequest $request, Instructor $instructor)
    {
        $instructor->update($request->validated());
        return response()->json($instructor);
    }

    public function destroy(Instructor $instructor)
    {
        $instructor->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $instructor = Instructor::withTrashed()->findOrFail($id);
        $instructor->restore();
        return response()->json($instructor);
    }

    public function forceDelete($id)
    {
        $instructor = Instructor::withTrashed()->findOrFail($id);
        $instructor->forceDelete();
        return response()->json(null, 204);
    }

    public function getInstructorByUserId($userId)
    {
        try {
            $instructor = Instructor::where('user_id', $userId)->first();

            if (!$instructor) {
                return response()->json(['error' => 'Instructor not found'], 404);
            }

            return response()->json($instructor);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function getInstructorsWithUserDetails()
    {
        $instructors = Instructor::with('user:id,first_name,middle_name,last_name')->get();
        return response()->json($instructors);
    }
}
