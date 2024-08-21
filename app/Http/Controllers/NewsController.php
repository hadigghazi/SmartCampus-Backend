<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Http\Requests\StoreNews;
use App\Http\Requests\UpdateNews;

class NewsController extends Controller
{
    public function index()
    {
        $items = News::get();
        return response()->json($items);
    }

    public function store(StoreNews $request)
    {
        $item = News::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = News::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateNews $request, $id)
    {
        $item = News::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = News::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = News::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = News::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }
}
