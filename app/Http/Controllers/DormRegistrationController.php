<?php

namespace App\Http\Controllers;

use App\Models\DormRegistration;
use App\Http\Requests\StoreDormRegistration;
use App\Http\Requests\UpdateDormRegistration;

class DormRegistrationController extends Controller
{
    public function index()
    {
        $items = DormRegistration::get();
        return response()->json($items);
    }

    public function store(StoreDormRegistration $request)
    {
        $item = DormRegistration::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = DormRegistration::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateDormRegistration $request, $id)
    {
        $item = DormRegistration::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = DormRegistration::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = DormRegistration::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = DormRegistration::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }

    public function getRegistrationsByDormRoom($dormRoomId)
    {
        $registrations = DormRegistration::where('dorm_room_id', $dormRoomId)->get();
        
        return response()->json($registrations);
    }
}
