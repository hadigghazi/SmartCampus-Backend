<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Http\Requests\StoreSubmission;
use App\Http\Requests\UpdateSubmission;

class SubmissionController extends Controller
{
    public function index()
    {
        $items = Submission::withTrashed()->get();
        return response()->json($items);
    }

    public function store(StoreSubmission $request)
    {
        $item = Submission::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = Submission::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateSubmission $request, $id)
    {
        $item = Submission::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Submission::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = Submission::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = Submission::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }
}
