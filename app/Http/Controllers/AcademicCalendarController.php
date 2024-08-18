<?php

namespace App\Http\Controllers;

use App\Models\AcademicCalendar;
use App\Http\Requests\StoreAcademicCalendar;
use App\Http\Requests\UpdateAcademicCalendar;

class AcademicCalendarController extends Controller
{
    public function index()
    {
        $items = AcademicCalendar::withTrashed()->get();
        return response()->json($items);
    }

    public function store(StoreAcademicCalendar $request)
    {
        $item = AcademicCalendar::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = AcademicCalendar::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateAcademicCalendar $request, $id)
    {
        $item = AcademicCalendar::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = AcademicCalendar::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = AcademicCalendar::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = AcademicCalendar::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }
}
