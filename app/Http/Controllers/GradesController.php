<?php

namespace App\Http\Controllers;

use App\Models\Grades;
use App\Http\Requests\StoreGrades;
use App\Http\Requests\UpdateGrades;

class GradesController extends Controller
{
    public function index()
    {
        $items = Grades::withTrashed()->get();
        return response()->json($items);
    }

    public function store(StoreGrades $request)
    {
        $item = Grades::create($request->validated());
        return response()->json($item, 201);
    }

    public function show(Grades $item)
    {
        return response()->json($item);
    }

    public function update(UpdateGrades $request, Grades $item)
    {
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy(Grades $item)
    {
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = Grades::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = Grades::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }
}
