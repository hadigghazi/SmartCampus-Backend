<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Http\Requests\StoreAssignment;
use App\Http\Requests\UpdateAssignment;

class AssignmentController extends Controller
{
    public function index()
    {
        $items = Assignment::get();
        return response()->json($items);
    }

    public function store(StoreAssignment $request)
    {
        $item = Assignment::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = Assignment::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateAssignment $request, $id)
    {
        $item = Assignment::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Assignment::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = Assignment::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = Assignment::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }
}
