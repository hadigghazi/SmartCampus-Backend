<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Http\Requests\StoreMajorRequest;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    public function index()
    {
        $majors = Major::withTrashed()->get();
        return response()->json($majors);
    }

    public function store(StoreMajorRequest $request)
    {
        $major = Major::create($request->validated());
        return response()->json($major, 201);
    }

    public function show(Major $major)
    {
        return response()->json($major);
    }

    public function update(StoreMajorRequest $request, Major $major)
    {
        $major->update($request->validated());
        return response()->json($major);
    }

    public function destroy(Major $major)
    {
        $major->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $major = Major::withTrashed()->findOrFail($id);
        $major->restore();
        return response()->json($major);
    }

    public function forceDelete($id)
    {
        $major = Major::withTrashed()->findOrFail($id);
        $major->forceDelete();
        return response()->json(null, 204);
    }
}
