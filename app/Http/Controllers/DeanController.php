<?php

namespace App\Http\Controllers;

use App\Models\Dean;
use App\Http\Requests\StoreDean;
use App\Http\Requests\UpdateDean;

class DeanController extends Controller
{
    public function index()
    {
        $items = Dean::get();
        return response()->json($items);
    }

    public function store(StoreDean $request)
    {
        $item = Dean::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = Dean::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateDean $request, $id)
    {
        $item = Dean::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Dean::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = Dean::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = Dean::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }

    public function getDeansByCampus($campusId)
    {
        $deans = Dean::where('campus_id', $campusId)
                     ->with('faculty') 
                     ->get();
                     
        return response()->json($deans);
    }

    public function getDeanByFacultyAndCampus($facultyId, $campusId)
{
    $dean = Dean::where('faculty_id', $facultyId)
                ->where('campus_id', $campusId)
                ->first();     

    if (!$dean) {
        return response()->json(['error' => 'Dean not found'], 404);
    }

    return response()->json($dean);
}

}
