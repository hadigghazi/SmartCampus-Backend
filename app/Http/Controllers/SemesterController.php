<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Http\Requests\StoreSemesterRequest;
use App\Http\Requests\UpdateSemesterRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class SemesterController extends Controller
{
    public function index()
    {
        $semester = Semester::all();
        return response()->json($semester);
    }

    public function store(StoreSemesterRequest $request)
    {
        $data = $request->validated();

        if (isset($data['is_current']) && $data['is_current']) {
            Semester::where('is_current', true)->update(['is_current' => false]);
        }

        $semester = Semester::create($data);
        return response()->json($semester, 201);
    }

    public function show(Semester $semester)
    {
        return response()->json($semester);
    }

    public function update(UpdateSemesterRequest $request, Semester $semester)
    {
        $data = $request->validated();
        
        if (isset($data['is_current']) && $data['is_current']) {
            Semester::where('id', '!=', $semester->id)
                ->where('is_current', true)
                ->update(['is_current' => false]);
        }

        $semester->update($data);
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

    public function getCurrentSemester(): JsonResponse
    {
        $currentSemester = Semester::where('is_current', true)->first();

        if (!$currentSemester) {
            return response()->json([
                'message' => 'No current semester found.'
            ], 404);
        }

        return response()->json($currentSemester, 200);
    }
}
