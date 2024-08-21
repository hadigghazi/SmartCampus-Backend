<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Http\Requests\StoreFacultyRequest;
use App\Http\Requests\UpdateFacultyRequest;

class FacultyController extends Controller
{
    public function index()
    {
        $faculties = Faculty::get();
        return response()->json($faculties);
    }

    public function store(StoreFacultyRequest $request)
    {
        $faculty = Faculty::create($request->validated());

        return response()->json($faculty, 201);
    }

    public function show(Faculty $faculty)
    {
        return response()->json($faculty);
    }

    public function update(UpdateFacultyRequest $request, Faculty $faculty)
    {
        $faculty->update($request->validated());

        return response()->json($faculty);
    }

    public function destroy(Faculty $faculty)
    {
        $faculty->delete();  
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $faculty = Faculty::withTrashed()->findOrFail($id);
        $faculty->restore();

        return response()->json($faculty);
    }

    public function forceDelete($id)
    {
        $faculty = Faculty::withTrashed()->findOrFail($id);
        $faculty->forceDelete();

        return response()->json(null, 204);
    }
}
