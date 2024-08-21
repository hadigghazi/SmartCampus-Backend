<?php

namespace App\Http\Controllers;

use App\Models\CourseMaterial;
use App\Http\Requests\StoreCourseMaterial;
use App\Http\Requests\UpdateCourseMaterial;

class CourseMaterialController extends Controller
{
    public function index()
    {
        $items = CourseMaterial::get();
        return response()->json($items);
    }

    public function store(StoreCourseMaterial $request)
    {
        $item = CourseMaterial::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = CourseMaterial::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateCourseMaterial $request, $id)
    {
        $item = CourseMaterial::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = CourseMaterial::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = CourseMaterial::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = CourseMaterial::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }
}
