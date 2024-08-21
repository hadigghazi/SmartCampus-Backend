<?php

namespace App\Http\Controllers;

use App\Models\ImportantDate;
use App\Http\Requests\StoreImportantDate;
use App\Http\Requests\UpdateImportantDate;

class ImportantDateController extends Controller
{
    public function index()
    {
        $items = ImportantDate::get();
        return response()->json($items);
    }

    public function store(StoreImportantDate $request)
    {
        $item = ImportantDate::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = ImportantDate::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateImportantDate $request, $id)
    {
        $item = ImportantDate::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = ImportantDate::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = ImportantDate::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = ImportantDate::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }
}
