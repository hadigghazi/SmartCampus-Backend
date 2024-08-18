<?php

namespace App\Http\Controllers;

use App\Models\LibraryBook;
use App\Http\Requests\StoreLibraryBook;
use App\Http\Requests\UpdateLibraryBook;

class LibraryBookController extends Controller
{
    public function index()
    {
        $items = LibraryBook::withTrashed()->get();
        return response()->json($items);
    }

    public function store(StoreLibraryBook $request)
    {
        $item = LibraryBook::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = LibraryBook::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateLibraryBook $request, $id)
    {
        $item = LibraryBook::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = LibraryBook::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = LibraryBook::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = LibraryBook::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }
}
