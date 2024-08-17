<?php

namespace App\Http\Controllers;

use App\Models\Center;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    public function index()
    {
        $centers = Center::withTrashed()->get();
        return response()->json($centers);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'vision' => 'nullable',
            'mission' => 'nullable',
            'overview' => 'nullable',
        ]);

        $center = Center::create($request->all());

        return response()->json($center, 201);
    }

    public function show(Center $center)
    {
        return response()->json($center);
    }

    public function update(Request $request, Center $center)
    {
        $request->validate([
            'name' => 'required|max:100',
            'vision' => 'nullable',
            'mission' => 'nullable',
            'overview' => 'nullable',
        ]);

        $center->update($request->all());

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
