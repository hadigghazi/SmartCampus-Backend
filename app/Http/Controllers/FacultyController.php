<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function index()
    {
        $faculties = Faculty::withTrashed()->get();
        return response()->json($faculties);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable',
        ]);

        $faculty = Faculty::create($request->all());

        return response()->json($faculty, 201);
    }

    public function show(Faculty $faculty)
    {
        return response()->json($faculty);
    }

    public function update(Request $request, Faculty $faculty)
    {
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable',
        ]);

        $faculty->update($request->all());

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
