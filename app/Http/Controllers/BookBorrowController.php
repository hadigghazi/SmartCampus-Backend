<?php

namespace App\Http\Controllers;

use App\Models\BookBorrow;
use App\Http\Requests\StoreBookBorrow;
use App\Http\Requests\UpdateBookBorrow;

class BookBorrowController extends Controller
{
    public function index()
    {
        $items = BookBorrow::get();
        return response()->json($items);
    }

    public function store(StoreBookBorrow $request)
    {
        $item = BookBorrow::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = BookBorrow::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateBookBorrow $request, $id)
    {
        $item = BookBorrow::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = BookBorrow::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = BookBorrow::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = BookBorrow::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }
}
