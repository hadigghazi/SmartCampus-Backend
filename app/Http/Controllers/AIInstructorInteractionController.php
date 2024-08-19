<?php

namespace App\Http\Controllers;

use App\Models\AIInstructorInteraction;
use App\Http\Requests\StoreAIInstructorInteraction;
use App\Http\Requests\UpdateAIInstructorInteraction;

class AIInstructorInteractionController extends Controller
{
    public function index()
    {
        $items = AIInstructorInteraction::withTrashed()->get();
        return response()->json($items);
    }

    public function store(StoreAIInstructorInteraction $request)
    {
        $item = AIInstructorInteraction::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = AIInstructorInteraction::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateAIInstructorInteraction $request, $id)
    {
        $item = AIInstructorInteraction::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = AIInstructorInteraction::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = AIInstructorInteraction::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = AIInstructorInteraction::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }

    public function clear()
{
    AIInstructorInteraction::query()->delete();

    return response()->json(['message' => 'All interactions have been deleted.']);
}
    
}
