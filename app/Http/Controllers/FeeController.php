<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Http\Requests\StoreFee;
use App\Http\Requests\UpdateFee;

class FeeController extends Controller
{
    public function index()
    {
        $items = Fee::withTrashed()->get();
        return response()->json($items);
    }

    public function store(StoreFee $request)
    {
        $item = Fee::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = Fee::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateFee $request, $id)
    {
        $item = Fee::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Fee::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = Fee::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = Fee::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }
}
