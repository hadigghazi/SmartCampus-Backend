<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Requests\StorePayment;
use App\Http\Requests\UpdatePayment;

class PaymentController extends Controller
{
    public function index()
    {
        $items = Payment::get();
        return response()->json($items);
    }

    public function store(StorePayment $request)
    {
        $item = Payment::create($request->validated());
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = Payment::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdatePayment $request, $id)
    {
        $item = Payment::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Payment::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = Payment::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = Payment::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }
}
