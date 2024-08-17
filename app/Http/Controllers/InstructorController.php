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
        $instructors = Instructor::withTrashed()->get();
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

}
