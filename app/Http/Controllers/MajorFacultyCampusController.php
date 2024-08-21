<?php

namespace App\Http\Controllers;

use App\Models\MajorFacultyCampus;
use App\Http\Requests\StoreMajorFacultyCampus;
use App\Http\Requests\UpdateMajorFacultyCampus;

class MajorFacultyCampusController extends Controller
{
    public function index()
    {
        $items = MajorFacultyCampus::withTrashed()->get();
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
}
