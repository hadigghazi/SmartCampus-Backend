<?php

namespace App\Http\Controllers;

use App\Models\MajorFacultyCampus;
use App\Http\Requests\StoreMajorFacultyCampus;
use App\Http\Requests\UpdateMajorFacultyCampus;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MajorFacultyCampusController extends Controller
{
    public function index()
    {
        $items = MajorFacultyCampus::get();
        return response()->json($items);
    }

    public function store(StoreMajorFacultyCampus $request)
    {
        $item = MajorFacultyCampus::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = MajorFacultyCampus::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateMajorFacultyCampus $request, $id)
    {
        $item = MajorFacultyCampus::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = MajorFacultyCampus::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = MajorFacultyCampus::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = MajorFacultyCampus::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }

    public function getMajorsByFacultyAndCampus($facultyId, $campusId)
    {
        $majors = DB::table('majors')
        ->join('majors_faculties_campuses', 'majors.id', '=', 'majors_faculties_campuses.major_id')
        ->join('faculties_campuses', 'majors_faculties_campuses.faculty_campus_id', '=', 'faculties_campuses.id')
        ->join('faculties', 'faculties_campuses.faculty_id', '=', 'faculties.id')
        ->where('faculties.id', $facultyId)
        ->where('faculties_campuses.campus_id', $campusId)
        ->select('majors.id as major_id', 'majors.name as major_name')
        ->get();

        return response()->json($majors);
    }

    public function attachMajorToFacultyCampus(Request $request)
{
    $validated = $request->validate([
        'major_id' => 'required|exists:majors,id',
        'faculty_campus_id' => 'required|exists:faculties_campuses,id',
    ]);

    $existingEntry = DB::table('majors_faculties_campuses')
        ->where('major_id', $validated['major_id'])
        ->where('faculty_campus_id', $validated['faculty_campus_id'])
        ->first();

    if ($existingEntry) {
        return response()->json(['message' => 'This major is already attached to the specified faculty and campus.'], 409);
    }

    $majorFacultyCampus = DB::table('majors_faculties_campuses')->insert($validated);

    return response()->json(['message' => 'Major attached successfully to the faculty and campus.'], 201);
}

public function detachMajorFromFacultyCampus(Request $request)
{
    $validated = $request->validate([
        'major_id' => 'required|exists:majors,id',
        'faculty_campus_id' => 'required|exists:faculties_campuses,id',
    ]);

    $deleted = DB::table('majors_faculties_campuses')
        ->where('major_id', $validated['major_id'])
        ->where('faculty_campus_id', $validated['faculty_campus_id'])
        ->delete();

    if ($deleted) {
        return response()->json(['message' => 'Major detached successfully from the faculty and campus.'], 200);
    } else {
        return response()->json(['message' => 'No such attachment found.'], 404);
    }
}

}
