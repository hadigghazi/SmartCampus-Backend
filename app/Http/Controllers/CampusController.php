<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Http\Requests\StoreCampusRequest;
use App\Http\Requests\UpdateCampusRequest;

class CampusController extends Controller
{
    public function index()
    {
        $campuses = Campus::get();
        return response()->json($campuses);
    }

    public function store(StoreCampusRequest $request)
    {
        $campus = Campus::create($request->validated());

        return response()->json($campus, 201);
    }

    public function show(Campus $campus)
    {
        return response()->json($campus);
    }

    public function update(UpdateCampusRequest $request, Campus $campus)
    {
        $campus->update($request->validated());

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
