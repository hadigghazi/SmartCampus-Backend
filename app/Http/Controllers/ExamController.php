<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Http\Requests\StoreExam;
use App\Http\Requests\UpdateExam;

class ExamController extends Controller
{
    public function index()
    {
        $items = Exam::withTrashed()->get();
        return response()->json($items);
    }

    public function store(StoreExam $request)
    {
        $item = Exam::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = Exam::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateExam $request, $id)
    {
        $item = Exam::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Exam::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = Exam::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = Exam::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }
}
