<?php

namespace App\Http\Controllers;

use App\Models\DormRoom;
use App\Http\Requests\StoreDormRoomRequest;
use App\Http\Requests\UpdateDormRoomRequest;

class DormRoomController extends Controller
{
    public function index()
    {
        $dormRooms = DormRoom::withTrashed()->get();
        return response()->json($dormRooms);
    }

    public function store(StoreDormRoomRequest $request)
    {
        $dormRoom = DormRoom::create($request->validated());
        return response()->json($dormRoom, 201);
    }

}
