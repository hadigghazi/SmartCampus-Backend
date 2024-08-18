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

}
