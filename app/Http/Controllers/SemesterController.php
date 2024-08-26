<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Http\Requests\StoreSemesterRequest;
use App\Http\Requests\UpdateSemesterRequest;

class SemesterController extends Controller
{
    public function index()
    {
        $semester = Semester::get();
        return response()->json($semester);
    }

    public function store(StoreSemesterRequest $request)
    {
        $semester = Semester::create($request->validated());
        return response()->json($semester, 201);
    }

    public function show(Semester $semester)
    {
        return response()->json($semester);
    }

    public function update(UpdateSemesterRequest $request, Semester $semester)
    {
        $semester->update($request->validated());
        return response()->json($semester);
    }

    public function destroy(Semester $semester)
    {
        $semester->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $semester = Semester::withTrashed()->findOrFail($id);
        $semester->restore();
        return response()->json($semester);
    }

    public function forceDelete($id)
    {
        $semester = Semester::withTrashed()->findOrFail($id);
        $semester->forceDelete();
        return response()->json(null, 204);
    }
}
