<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    public function index()
    {
        $campuses = Campus::withTrashed()->get();
        return response()->json($campuses);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'location' => 'required|max:100',
            'description' => 'nullable',
        ]);

        $campus = Campus::create($request->all());

        return response()->json($campus, 201);
    }

    public function show(Campus $campus)
    {
        return response()->json($campus);
    }

    public function update(Request $request, Campus $campus)
    {
        $request->validate([
            'name' => 'required|max:100',
            'location' => 'required|max:100',
            'description' => 'nullable',
        ]);

        $campus->update($request->all());

        return response()->json($campus);
    }

    public function destroy(Campus $campus)
    {
        $campus->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $campus = Campus::withTrashed()->findOrFail($id);
        $campus->restore();

        return response()->json($campus);
    }

    public function forceDelete($id)
    {
        $campus = Campus::withTrashed()->findOrFail($id);
        $campus->forceDelete();

        return response()->json(null, 204);
    }
}
