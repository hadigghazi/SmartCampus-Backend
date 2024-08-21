<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Http\Requests\StoreGrade;
use App\Http\Requests\UpdateGrade;

class GradeController extends Controller
{
    public function index()
    {
        $items = Grade::get();
        return response()->json($items);
    }

    public function store(StoreGrade $request)
    {
        $item = Grade::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = Grade::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateGrade $request, $id)
    {
        $item = Grade::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Grade::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = Grade::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = Grade::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }
}
