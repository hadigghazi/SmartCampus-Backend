<?php

namespace App\Http\Controllers;

use App\Models\BusRegistration;
use App\Http\Requests\StoreBusRegistration;
use App\Http\Requests\UpdateBusRegistration;

class BusRegistrationController extends Controller
{
    public function index()
    {
        $items = BusRegistration::get();
        return response()->json($items);
    }

    public function store(StoreBusRegistration $request)
    {
        $item = BusRegistration::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = BusRegistration::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateBusRegistration $request, $id)
    {
        $item = BusRegistration::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = BusRegistration::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = BusRegistration::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = BusRegistration::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }
}
