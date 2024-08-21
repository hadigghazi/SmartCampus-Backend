<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Http\Requests\StoreAnnouncement;
use App\Http\Requests\UpdateAnnouncement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $items = Announcement::get();
        return response()->json($items);
    }

    public function store(StoreAnnouncement $request)
    {
        $item = Announcement::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = Announcement::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateAnnouncement $request, $id)
    {
        $item = Announcement::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Announcement::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = Announcement::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = Announcement::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }
}
