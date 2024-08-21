<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Http\Requests\StoreCenterRequest;
use App\Http\Requests\UpdateCenterRequest;

class CenterController extends Controller
{
    public function index()
    {
        $centers = Center::get();
        return response()->json($centers);
    }

    public function store(StoreCenterRequest $request)
    {
        $center = Center::create($request->validated());

        return response()->json($center, 201);
    }

    public function show(Center $center)
    {
        return response()->json($center);
    }

    public function update(UpdateCenterRequest $request, Center $center)
    {
        $center->update($request->validated());

        return response()->json($center);
    }

    public function destroy(Center $center)
    {
        $center->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $center = Center::withTrashed()->findOrFail($id);
        $center->restore();

        return response()->json($center);
    }

    public function forceDelete($id)
    {
        $center = Center::withTrashed()->findOrFail($id);
        $center->forceDelete();

        return response()->json(null, 204);
    }
}
