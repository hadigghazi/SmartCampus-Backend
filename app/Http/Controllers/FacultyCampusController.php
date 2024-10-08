<?php

namespace App\Http\Controllers;

use App\Models\FacultyCampus;
use App\Http\Requests\StoreFacultyCampusRequest;
use App\Http\Requests\UpdateFacultyCampusRequest;
use Illuminate\Http\Request;

class FacultyCampusController extends Controller
{
    public function index()
    {
        $facultyCampuses = FacultyCampus::get();
        return response()->json($facultyCampuses);
    }

    public function store(StoreFacultyCampusRequest $request)
    {
        $facultyCampus = FacultyCampus::create($request->validated());
        return response()->json($facultyCampus, 201);
    }

    public function show($id)
    {
        $facultyCampus = FacultyCampus::withTrashed()->findOrFail($id);
        if ($facultyCampus->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($facultyCampus);
    }

    public function update(UpdateFacultyCampusRequest $request, $id)
    {
        $facultyCampus = FacultyCampus::withTrashed()->findOrFail($id);
        $facultyCampus->update($request->validated());
        return response()->json($facultyCampus);
    }

    public function destroy($id)
    {
        $facultyCampus = FacultyCampus::findOrFail($id);
        $facultyCampus->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $facultyCampus = FacultyCampus::withTrashed()->findOrFail($id);
        $facultyCampus->restore();
        return response()->json($facultyCampus);
    }

    public function forceDelete($id)
    {
        $facultyCampus = FacultyCampus::withTrashed()->findOrFail($id);
        $facultyCampus->forceDelete();
        return response()->json(null, 204);
    }

    public function facultiesByCampus($campusId)
    {
        $facultyCampuses = FacultyCampus::where('campus_id', $campusId)->with('faculty')->get();
        return response()->json($facultyCampuses->pluck('faculty'));
    }

    public function campusesByFaculty($facultyId)
    {
        $facultyCampuses = FacultyCampus::where('faculty_id', $facultyId)->with('campus')->get();
        return response()->json($facultyCampuses->pluck('campus'));
    }

    public function attachFacultyToCampus(Request $request, $campusId)
    {
        $facultyId = $request->input('faculty_id');
    
        $facultyCampus = FacultyCampus::updateOrCreate(
            ['faculty_id' => $facultyId, 'campus_id' => $campusId]
        );
    
        return response()->json($facultyCampus, 201);
    }

    public function detachFacultyFromCampus($campusId, $facultyId)
    {
        FacultyCampus::where('campus_id', $campusId)
            ->where('faculty_id', $facultyId)
            ->delete();
    
        return response()->json(null, 204);
    }


public function getFacultyCampusId($facultyId, $campusId)
{
    $facultyCampus = FacultyCampus::where('faculty_id', $facultyId)
                                  ->where('campus_id', $campusId)
                                  ->first();

    if ($facultyCampus) {
        return response()->json(['faculty_campus_id' => $facultyCampus->id]);
    }

    return response()->json(['message' => 'Not found'], 404);
}



}
