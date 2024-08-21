<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;

class AddressController extends Controller
{
    public function index()
    {
        return Address::get();
    }

    public function store(StoreAddressRequest $request)
    {
        $address = Address::create($request->validated());
        return response()->json($address, 201);
    }

    public function show(Address $address)
{
    if ($address->trashed()) {
        return response()->json(['error' => 'Address not found'], 404);
    }

    return response()->json($address);
}


    public function update(UpdateAddressRequest $request, $id)
    {
        $address = Address::withTrashed()->findOrFail($id);
        $address->update($request->validated());
        return response()->json($address);
    }

    public function destroy(Address $address)
    {
        $address->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $address = Address::withTrashed()->findOrFail($id);
        $address->restore();
        return response()->json($address);
    }

    public function forceDelete($id)
    {
        $address = Address::withTrashed()->findOrFail($id);
        $address->forceDelete();
        return response()->json(null, 204);
    }
}
