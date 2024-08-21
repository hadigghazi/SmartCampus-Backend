<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::get();
        return response()->json($rooms);
    }

    public function store(StoreRoomRequest $request)
    {
        $room = Room::create($request->validated());

        return response()->json($room, 201);
    }

    public function show(Room $room)
    {
        return response()->json($room);
    }

    public function update(UpdateRoomRequest $request, Room $room)
    {
        $room->update($request->validated());

        return response()->json($room);
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $room = Room::withTrashed()->findOrFail($id);
        $room->restore();

        return response()->json($room);
    }

    public function forceDelete($id)
    {
        $room = Room::withTrashed()->findOrFail($id);
        $room->forceDelete();

        return response()->json(null, 204);
    }
}
