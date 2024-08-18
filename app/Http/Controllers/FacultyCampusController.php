<?php

namespace App\Http\Controllers;

use App\Models\FacultyCampus;
use Illuminate\Http\Request;

class FacultyCampusController extends Controller
{
    public function index()
    {
        $facultiesCampuses = FacultyCampus::withTrashed()->get();
        return response()->json($facultiesCampuses);
    }

    public function facultiesByCampus($campusId)
    {
        $faculties = FacultyCampus::where('campus_id', $campusId)
            ->with('faculty')
            ->get()
            ->pluck('faculty');
        return response()->json($faculties);
    }

    public function store(Request $request)
    {
        $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'campus_id' => 'required|exists:campuses,id',
        ]);

        $facultyCampus = FacultyCampus::create($request->all());
        return response()->json($facultyCampus, 201);
    }

    public function show($id)
    {
        $facultyCampus = FacultyCampus::withTrashed()->findOrFail($id);
        return response()->json($facultyCampus);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'faculty_id' => 'sometimes|required|exists:faculties,id',
            'campus_id' => 'sometimes|required|exists:campuses,id',
        ]);

        $facultyCampus = FacultyCampus::findOrFail($id);
        $facultyCampus->update($request->all());
        return response()->json($facultyCampus);
    }

    public function destroy($id)
    {
        $facultyCampus = FacultyCampus::findOrFail($id);
        $facultyCampus->delete();
        return response()->json(null, 204);
    }

}
