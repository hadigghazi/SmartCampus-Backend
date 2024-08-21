<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Http\Requests\StoreRegistration;
use App\Http\Requests\UpdateRegistration;

class RegistrationController extends Controller
{
    public function index()
    {
        $items = Registration::get();
        return response()->json($items);
    }

    public function store(StoreRegistration $request)
    {
        $item = Registration::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
{
    $item = FacultyCampus::withTrashed()->findOrFail($id);
    if ($item->trashed()) {
        return response()->json(['error' => 'Not found'], 404);
    }
    return response()->json($item);
}

public function update(UpdateRegistration $request, $id)
{
    $item = Registration::withTrashed()->findOrFail($id);
    $item->update($request->validated());
    return response()->json($item);
}

public function destroy($id)
{
    $item = Registration::withTrashed()->findOrFail($id);
    $item->delete();
    return response()->json(null, 204);
}


    public function restore($id)
    {
        $item = Registration::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = Registration::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }
}
